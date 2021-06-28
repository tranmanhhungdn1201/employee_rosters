<?php

namespace App\Http\Controllers;

use App\Http\Traits\RosterTrait;
use App\Http\Traits\UserTypeTrait;
use Illuminate\Http\Request;
use App\Models\Roster;
use App\Models\UserType;
use App\Models\Shift;
use Config;
use Carbon\Carbon;
use DB;
use Datatables;

class RosterController extends Controller
{
    use UserTypeTrait, RosterTrait;

    public function viewCreateRoster(Request $request){
        $userTypes = $this->getUserTypeStaff();
        $copyID = $request['copy'];
        $data = null;
        if(!empty($copyID)) {
            $data = Shift::select(['id', 'user_type_id', 'time_start', 'time_finish', 'amount'])->where('roster_id', $copyID)->get();
        }
        return response()->view('create_roster', [
                'userTypes' => $userTypes,
                'data' => $data
            ]);
    }

    public function listRoster($branchID){
        return response()->view('listRoster', ['branchID' => $branchID]);
    }

    public function getListRosterDatatables($branchID){
        //update all roster
        $this->checkAllRoster();
        $rosters = Roster::where('branch_id', $branchID)->get();
        return Datatables::of($rosters)
        ->addColumn('status_roster', function($data){
            switch($data->status){
                case '1':
                    $bgColor = 'badge-warning';
                    break;
                case '2':
                    $bgColor = 'badge-success';
                    break;
                case '3':
                    $bgColor = 'badge-dark';
                    break;
                default:
                    $bgColor = '';
            }
            $content = '<span class="badge ' . $bgColor. '">' . $data->status_name . '</span>';
            return $content;
        })
        ->addColumn('action', function($data) {
            $buttonView = '<a href="'.route('singleRoster', $data->id) .'" class="btn btn-info btn-sm btn-view"><i class="fas fa-eye"></i></a>';
            $buttonCopy = '&nbsp;<a href="' . route('viewCreateRoster') . '?copy='. $data->id .'" class="btn btn-info btn-sm btn-copy"><i class="fas fa-copy"></i></a>';
            $button = $buttonView . $buttonCopy;
            if(auth()->user()->isStaff()) {
                $button = $buttonView;
            }
            return $button; 
        })
        ->rawColumns(['status_roster', 'action'])
        ->make(true);
    }

    public function createRoster(Request $request){
        $dataRoster = $request->dataRoster;
        $timeStart = $request->timeStart;
        $timeOpen = $request->timeOpen;
        $dataR = [
            'day_start' => $timeStart['timeStart'],
            'day_finish' => $timeStart['timeFinish'],
            'time_open' => $timeOpen['timeOpen'],
            'time_close' => $timeOpen['timeClose'],
            'status' => Config::get('constants.status_roster.PENDING'),
            'user_created_id' => auth()->user()->id,
            'user_updated_id' => auth()->user()->id,
            'branch_id' => 1       
        ];
        DB::beginTransaction();
        try {
            //create roster and get id
            $roster = Roster::create($dataR);
            if(empty($roster)) {
                DB::rollBack();
                return response()->json([
                    'Status' => 'Fail',
                    'Message' => 'Create roster fail'
                ]);
            }

            //create shifts and get id
            foreach($dataRoster as $shift) {
                for($i = 0; $i < 7; $i++) {
                    $date = Carbon::createFromFormat('Y-m-d',  $timeStart['timeStart'])->addDays($i);
                    $data = [
                        'roster_id' => $roster->id,
                        'time_start' => $shift['shift_start'],
                        'time_finish' => $shift['shift_finish'],
                        'user_type_id' => $shift['type'],
                        'date' => $date,
                        'amount' => $shift['day_' . $i],
                        'status' => $shift['day_' . $i] === 0 ? Config::get('constants.status_shift.FULL') : Config::get('constants.status_shift.OPEN'), 
                        'user_created_id' => auth()->user()->id, 
                    ];
                    Shift::create($data);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'Status' => 'Fail',
                'Message' => $e->getMessage()
            ]);
        }
        
        return response()->json([
            'Status' => 'Success',
            'Message' => 'Create roster successfully',
            'rosterID' => $roster->id,
        ]);
    }

    public function singleRoster(Request $request, $id){
        
        if(empty($id)) return;
        $roster = Roster::find($id);
        if(empty($roster)) return redirect()->back();
        $shifts = $this->getDataShift($id);
        $shifts = $this->formatDataShift($shifts);
        $userTypes = $this->getUserTypeStaff();
        $view = 'single_roster';
        $requestQuery = $request->query();
        if(isset($requestQuery['edit_view']) && $requestQuery['edit_view'] === 'true') {
            $view = 'singleRosterAdmin';
        }
        return response()->view($view, [
            'roster' => $roster,
            'shifts' => $shifts,
            'userTypes' => $userTypes,
        ]);
    }

    public function getDataShift($rosterId){
        if(empty($rosterId)) return;
        $shifts = Shift::withCount('userShifts')
        ->where('roster_id', $rosterId)
        ->orderBy('time_start', 'asc')
        ->orderBy('date', 'asc')
        ->get();
        return $shifts;
    }

    public function formatDataShift($shifts){
        $data = array();
        $length = count($shifts);
        $lengthShift = $length/7;
        for($i = 0; $i < $lengthShift; $i++) {
            $time = $shifts[7 * $i]->time_start .' - '. $shifts[7 * $i]->time_finish;
            $data[$time] = array();
            for($j = 7*$i; $j < 7*($i + 1); $j++) {
                array_push($data[$time], $shifts[$j]);
            }
        }

        return $data;
    }

    public function getDataShiftExport($rosterId){
        if(empty($rosterId)) return;
        $shifts = Shift::with('userShifts')
        ->where('roster_id', $rosterId)
        ->orderBy('time_start', 'asc')
        ->orderBy('date', 'asc')
        ->get();
        return $shifts;
    }

    public function exportRoster($rosterId)
    {
        $roster = Roster::find($rosterId);
        if(empty($roster))  
            return response()->json([
                'success' => false,
                'message' => 'Không có dữ liệu.',
            ],200);
        $shifts = $this->getDataShiftExport($rosterId);
        $shifts = $this->formatDataShift($shifts);
        if(count($shifts) > 0){
            $pathFileTemplate = resource_path('excels/roster.xlsx');
            $fileType = \PHPExcel_IOFactory::identify($pathFileTemplate);
            $objReader = \PHPExcel_IOFactory::createReader($fileType);
            $objPHPExcel = $objReader->load($pathFileTemplate);
            $this->addDataToExcelFile($objPHPExcel->setActiveSheetIndex(0), $shifts, $roster);
            $fileName = $roster->day_start . '-' . $roster->day_finish . '-roster-register.xlsx';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $fileName .'"');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            ob_start();
            $objWriter->save('php://output');
            $excelData = ob_get_contents();
            ob_end_clean();
            return response()->json([
                    'success'  => true,
                    'fileName' => $fileName,
                    'url'      => "data:application/vnd.ms-excel;base64," . base64_encode($excelData),
                    'message'  => 'Xuất file thành công'
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Không có dữ liệu.',
        ],200);
    }

    private function addDataToExcelFile($setCell, $data, $roster)
    {
        $userType = UserType::all();
        $setCell->setCellValue('B1', 'LỊCH ĐĂNG KÝ TUẦN LÀM VIÊC: TỪ '. $roster->day_start .' ĐẾN '. $roster->day_finish);
        $row = 4;
        $arrCol = array(
            0 => "C",
            1 => "D",
            2 => "E",
            3 => "F",
            4 => "G",
            5 => "H",
            6 => "I",
        );
        foreach($data as $key1 => $shift){
            $countRow = 1;
            $setCell
                ->setCellValue('A' . $row, $key1);
            for($i = 0; $i < 7; $i++) {
                if($shift[$i]) {
                    $setCell
                        ->setCellValue('B' . $row, $userType->where('id', $shift[$i]->user_type_id)->first()->name);
                    if($shift[$i]->userShifts) {
                        $rowPlus = $row;
                        foreach($shift[$i]->userShifts as $key2 => $userShift){
                            $setCell
                            ->setCellValue($arrCol[$i] . $rowPlus, $userShift->user->full_name);
                            if(count($shift[$i]->userShifts) > 1) {
                                $rowPlus++;
                            }
                        }
                        if(($rowPlus - $row  + 1) > $countRow) {
                            $countRow++;
                        }
                    }
                }
            }
            $row += $countRow;
        }
        return $this;
    }

    public function updateTimeRegister(Request $request) {
        $data = [
            'time_open' => Carbon::createFromFormat('d-m-Y H:i', $request['timeBegin']),
            'time_close' => Carbon::createFromFormat('d-m-Y H:i', $request['timeClose']),
        ];
        $idRoster = $request['idRoster'];
        $roster = Roster::find($idRoster)->update($data);
        if(empty($roster)) {
            return response()->json([
                'Status' => 'Fail',
                'Message' => 'Update time fail',
            ]);
        }
        $status = $this->checkRosterById($idRoster);

        return response()->json([
            'Status' => 'Success',
            'Message' => 'Update time successfully',
            'statusRoster' => $status
        ]);
    }
}
