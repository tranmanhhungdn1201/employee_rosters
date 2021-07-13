@extends('master')
@section('content')
<div class="row mx-0">
    <div class="card">
        <div class="card-header">
            <div class="card-header__icon">
                <img alt="alt text" src="{!! asset('image/roster.svg') !!}">
                Bảng phân công
            </div>
            <div class="card-header__action">
                <a href="{{route('viewCreateRoster')}}" class="btn btn-outline-primary btn-export">
                <i class="fas fa-file-download"></i>
                Xuất file
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-md-2">
                <div class="col-md-6 pr-lg-4 pr-xl-5">
                    <div class="form-group row no-gutters align-items-center">
                        <label for="roster_start" class="col-xl-4 col-form-label">&nbsp;Ngày bắt đầu</label>
                        <div class="col-xl-8 font-weight-bold">
                            <?php echo date('d-m-Y', strtotime($roster->day_start)); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 pl-lg-4 pl-xl-5">
                    <div class="form-group row no-gutters align-items-center">
                        <label for="roster_end" class="col-xl-4 col-form-label">&nbsp;Ngày kết thúc</label>
                        <div class="col-xl-8 font-weight-bold">
                            <?php echo date('d-m-Y', strtotime($roster->day_finish)); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-md-2">
                <div class="col-md-6 pr-lg-4 pr-xl-5">
                    <div class="form-group row no-gutters align-items-center">
                        <label for="roster_begin" class="col-xl-4 col-form-label">&nbsp;Ngày giờ mở đăng kí</label>
                        <div class="col-xl-8 font-weight-bold">
                            <?php echo date('d-m-Y H:i', strtotime($roster->time_open)); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 pl-lg-4 pl-xl-5">
                    <div class="form-group row no-gutters align-items-center">
                        <label for="roster_close" class="col-xl-4 col-form-label">&nbsp;Ngày giờ đóng đăng kí</label>
                        <div class="col-xl-8 font-weight-bold">
                            <?php echo date('d-m-Y H:i', strtotime($roster->time_close)); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-md-2">
                <div class="col-md-6 pr-lg-4 pr-xl-5">
                    <div class="form-group row no-gutters align-items-center">
                        <label for="roster_start" class="col-sm-4 col-form-label">Trạng thái</label>
                        <div class="col-sm-8">
                            <?php
                                switch($roster->status){
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
                            ?>
                            <a href="#"><span class="{{'badge ' . $bgColor}}">{{$roster->status_name}}</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-roster" id="roster-table">
                    <thead>
                        <tr>
                            <th scope="col">Thời gian</th>
                            <th scope="col">Bộ phận</th>
                            <th scope="col">Thứ 2</th>
                            <th scope="col">Thứ 3</th>
                            <th scope="col">Thứ 4</th>
                            <th scope="col">Thứ 5</th>
                            <th scope="col">Thứ 6</th>
                            <th scope="col">Thứ 7</th>
                            <th scope="col">Chủ nhật</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (is_array($shifts))
                            @foreach($shifts as $key => $shift)
                            <tr data-shift="{{ $shift[0] }}">
                                <td class="shift-row shift_start shift_finish"><div class="table-roster__time">{{ date('H:i', strtotime($shift[0]->time_start)) .' - '. date('H:i', strtotime($shift[0]->time_finish))}}</div></td>
                                <td class="shift-row type"><div class="table-roster__type">{{ $shift[0]->user_type_name }}</div></td>
                                @foreach($shift as $indexDay => $day)
                                    <?php
                                        $state = '';
                                        switch($day->status){
                                            case $day->isRegistered:
                                                $bgColor = 'bg-warning';
                                                $state = 'isRegistered';
                                                break;
                                            case 1:
                                                $bgColor = 'bg-success';
                                                break;
                                            case 2:
                                                $bgColor = 'bg-danger';
                                                break;
                                            case 3:
                                                $bgColor = 'bg-dark';
                                                break;
                                            default:
                                                $bgColor = '';
                                        }
                                    ?>
                                    <td data-state ="{{$state}}" class="{{$bgColor . ' day_' . $indexDay . ' shift_' . $day->id}} shift-date table-roster__column" data-id="{{ $day->id }}">
                                        <div class="table-roster__cell d-flex flex-column align-items-center" data-id="{{ $day->id }}">
                                            <div class="mb-2">
                                                <span>{{$day->user_shifts_count}}/{{ $day->amount }}</span>
                                            </div>
                                            <div class="table-roster__cell__action">
                                                @if(auth()->user()->isAdmin() || (auth()->user()->isManager() && auth()->user()->id === $roster->user_created_id))
                                                <a href="#" data-action="edit" class="btn-edit-shift" data-id="{{$day->id}}"><i class="fas fa-pencil-alt"></i></a>
                                                @endif
                                            </div>
                                            <ul class="table-roster__users d-flex flex-column align-items-center">
                                                @foreach($day->userShifts as $user_shift)
                                                    <li class="table-roster__user d-flex align-items-center p-1 pr-3" style="white-space: nowrap;" data-user-id={{$user_shift->user->id}} data-user-shift-id="{{$user_shift->id}}">
                                                        {{$user_shift->user->full_name}}
                                                        <a href="#/" data-action="del" class="btn-del-user" data-shift-id="{{$day->id}}"><i class="fas fa-trash-alt"></i></a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <input type="hidden" name="user_shift" data-shift-id="{{$day->id}}" value="{{$day->userShifts}}">
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                Nothing
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-center">
            <button class="btn btn-success btn-submit" id="btn-submit">Lưu</button>
        </div>
    </div>
</div>
@include('modal.shift')
@include('modal.add-staff')
<script type="text/javascript">
    $(document).ready(function () {
        // to save data
        let dataStaff = {};
        //get staff form server
        let STAFFS = {!! json_encode($staffs) !!};
        STAFFS = STAFFS.map(staff => {
            return {
                'id': staff['id'],
                'name': staff['full_name'],
                'text': staff['full_name'],
                'user_type_id': staff['user_type_id']
            }
        });

        // init select2
        let selectStaff = $('#select-staff').select2();
        // to save data oldRegister oin shift
        let dataRegister;

        //fill data & open modal
        $('.btn-edit-shift').on('click', function() {
            //get list userID registered
            let parent = $(this).parent().parent();
            let shiftID = $(this).attr('data-id');
            //set data user registed in the shift
            let dataRegister = getDataUserRegister(shiftID);
            //init data for select2
            let dataJson = JSON.stringify(STAFFS);
            let data = JSON.parse(dataJson);
            data.forEach(staff => {
                let idx = dataRegister.findIndex(user => user.userID === staff.id.toString())
                if(idx !== -1) {
                    staff.name = dataRegister[idx].name;
                    staff.shiftID = dataRegister[idx].shiftID;
                    staff.userShiftID = dataRegister[idx].userShiftID;
                    staff.selected = true;
                    staff.isRegistered = true;
                }
            });
            //set data for select2
            $('#select-staff').empty();
            $('#select-staff').select2({
                data: data
            });
            $('[name=shiftID]').val(shiftID);
            $('#add-staff-modal').modal('show');
        });

        function getDataUserRegister(shiftID){
            let shiftDOM = $(`.shift_${shiftID}`);
            let userList = [];
            $(shiftDOM).find('li').each((idx, ele) => {
                userList.push(
                    {
                        name: $(ele).text().trim(),
                        userID: $(ele).attr('data-user-id'),
                        shiftID,
                    });
            });

            return userList;
        }

        //event save shift
        $('#save-shift').click(function() {
            let data = $('#select-staff').select2('data');
            let shiftID = $('[name=shiftID]').val();
            $('#add-staff-modal').modal('hide');
            updateUIUserRegister(data, shiftID);
        });

        // draw UI when delete or add new staff
        function updateUIUserRegister(data, shiftID) {
            let shiftDOM = $(`.shift_${shiftID}`);
            $(shiftDOM).find('li').remove();
            let content = data.map(user =>
                `<li class="table-roster__user d-flex align-items-center p-1 pr-3" style="white-space: nowrap;" data-user-id="${user.id}">
                    ${user.name}
                    <a href="#/" data-action="del" class="btn-del-user"><i class="fas fa-trash-alt"></i></a>
                </li>`
            )
            shiftDOM.find('ul').append(content.join(''));
        }

        $('.btn-del-user').on('click', function() {
            $(this).closest('li').remove();
        })

        //filter data delete or add to dataStaff
        function mapData(dataOrigin, dataNew) {
            //empty data => return
            let rs = [];
            let isChange = false;
            if(dataOrigin.length === 0 && dataNew.length === 0) return rs;

            if(dataOrigin.length === 0) {
                isChange = true;
                rs = dataNew;
            } else if(dataNew.length === 0) {
                isChange = true;
                rs = dataOrigin.map(user => {
                   return {
                       ...user,
                       isRemoved: true
                   }
                })
            } else {//merge both
                dataOrigin.forEach((user, idx) => {
                    let index = dataNew.findIndex(userNew => userNew.userID === user.userID);
                    if(index === -1) {
                        rs.push({
                            ...user,
                            isRemoved: true
                        })
                    } else {
                        dataNew.splice(index, 1);
                    }
                })
                if(dataNew.length > 0) {
                    isChange = true;
                    rs.push(...dataNew);
                }
            }
            return {
                rs,
                isChange
            };
        }

        function initNewObjectShiftStaff(shiftID, data) {
            if(!dataStaff[shiftID])
               dataStaff[shiftID] = data;
        }

        $('#btn-submit').click(function() {
            getDataRegister();
            if(JSON.stringify(dataStaff) === '{}') {
                toastr.info('Dữ liệu không thay đổi');
                return;
            }
            let data = filterData();
            const url = "{{route('updateRoster')}}";
            const options = {
                url,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    data
                },
                success: function(res) {
                    if(res.Status === 'Success') {
                        location.reload();
                    }
                    $('#shift-time-modal').modal('hide');
                },
                error: function(err) {
                    console.error(err.message);
                }
            }
            $.ajax(options);
        })

        function getDataRegister() {
            let domeShift = $('.shift-date').find('input[type=hidden]');
            dataStaff = {};
            domeShift.each(function(idx, ele) {
                let dataOrigin = JSON.parse($(ele).val());
                dataOrigin = formatDataOrigin(dataOrigin);
                let shiftID = $(ele).attr('data-shift-id');
                let dataNew = getDataUserRegister(shiftID);
                let {rs, isChange} = mapData(dataOrigin, dataNew);
                if(isChange) {
                    initNewObjectShiftStaff(shiftID, rs);
                }
            })
            console.log(dataStaff);
        }

        function filterData() {
            let data = JSON.parse(JSON.stringify(dataStaff));
            let dataRemove = [];
            let dataAdd = [];
            for(let id in data) {
                data[id].forEach(staff => {
                    if(staff.isRemoved)
                        dataRemove.push(staff.userShiftID);
                    else
                        dataAdd.push({
                        ...staff
                        });
                })
            }
            console.log({
                dataRemove,
                dataAdd
            })
            return {
                dataRemove,
                dataAdd
            }
        }

        function formatDataOrigin(data) {
            return data.map(userShift => {
                return {
                    name: userShift.user.full_name,
                    shiftID: userShift.shift_id.toString(),
                    userID: userShift.user_id.toString(),
                    userShiftID: userShift.id
                }
            })
        }

        $('.btn-export').on('click', function () {
        let url = "{{ route('exportRoster', ':id') }}";
        let rosterId  = "{{ $roster->id }}";
        url = url.replace(':id', rosterId);
        loading('show');
        if(rosterId){
        //   $(this).prop('disabled', true);
          let option = {
            url: url,
            type: 'get',
            success: function(data) {
              if(data.success){
                let elementButtonDownload = document.createElement('a');
                $('.btn-export').after(elementButtonDownload);
                elementButtonDownload.setAttribute('href', data.url);
                elementButtonDownload.setAttribute('download', data.fileName);
                elementButtonDownload.click();
                elementButtonDownload.remove();
                toastr.success(data.message);
              }else{
                toastr.error(data.message);
              }
              loading('hide');
              $('.btn-export').prop('disabled', false);
            },
            error: function() {
                loading('hide');
              toastr.error("Lỗi");
              $('.btn-export').prop('disabled', false);
            }
          };
          $.ajax(option);
        }else{
          loading('hide');
          toastr.error("Lỗi");
        }
      });
    });
</script>
@endsection
