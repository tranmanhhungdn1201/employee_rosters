@extends('master')
@include('header')
@section('content')
<?php
  $disabled = $roster->status === Config::get('constants.status_roster.CLOSE') ? true : false;
?>
<div class="row mx-0">
    <div class="card">
        <div class="card-header">
            <div class="card-header__icon">
                <img alt="alt text" src="{!! asset('image/roster.svg') !!}">
            </div>
            Bảng phân công
            @if(!auth()->user()->isStaff())
                <div class="card-header__action">
                    <a href="{{route('viewCreateRoster')}}" class="btn btn-outline-primary btn-export">
                    <i class="fas fa-file-download"></i>
                    Xuất file
                    </a>
                </div>
            @endif
        </div>
        <form id="form-update">
            <div class="card-body">
                <div class="row mb-md-2">
                    <div class="col-md-6 pr-lg-4 pr-xl-5">
                        <div class="form-group row no-gutters">
                            <label for="roster_start" class="col-xl-4 col-form-label"><span class="text-danger">*</span>&nbsp;Ngày bắt đầu</label>
                            <div class="col-xl-8">
                            <div class="input-group date" id="roster_start" data-target-input="nearest">
                                <input type="text" placeholder="dd-mm-yyyy" class="form-control datetimepicker-input" name="roster_start" data-target="#roster_start" data-toggle="datetimepicker" 
                                    value="<?php echo date('d-m-Y', strtotime($roster->day_start)); ?>" disabled>
                                <!-- <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" data-target="#roster_start" data-toggle="datetimepicker"><i class="fas fa-calendar-alt"></i></button>
                                </div> -->
                            </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 pl-lg-4 pl-xl-5">
                        <div class="form-group row no-gutters">
                            <label for="roster_end" class="col-xl-4 col-form-label"><span class="text-danger">*</span>&nbsp;Ngày kết thúc</label>
                            <div class="col-xl-8">
                                <div class="input-group date" id="roster_end">
                                    <input type="text" placeholder="dd-mm-yyyy" class="form-control" name="roster_end" value="<?php echo date('d-m-Y', strtotime($roster->day_finish)); ?>" disabled/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-md-2">
                    <div class="col-md-6 pr-lg-4 pr-xl-5">
                        <div class="form-group row no-gutters">
                            <label for="roster_begin" class="col-xl-4 col-form-label"><span class="text-danger">*</span>&nbsp;Ngày giờ mở đăng kí</label>
                            <div class="col-xl-8">
                                <div class="input-group date" id="roster_begin" data-target-input="nearest">
                                    <input type="text" placeholder="dd-mm-yyyy hh:mm" class="form-control datetimepicker-input" name="roster_begin" data-target="#roster_begin" data-toggle="datetimepicker" 
                                        value="<?php echo date('d-m-Y H:i', strtotime($roster->time_open)); ?>" required pattern="^\d{2}-\d{2}-\d{4} \d\d:\d\d$">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" data-target="#roster_begin" data-toggle="datetimepicker"><i class="fas fa-calendar-alt"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 pl-lg-4 pl-xl-5">
                        <div class="form-group row no-gutters">
                            <label for="roster_close" class="col-xl-4 col-form-label"><span class="text-danger">*</span>&nbsp;Ngày giờ đóng đăng kí</label>
                            <div class="col-xl-8">
                            <div class="input-group date" id="roster_close" data-target-input="nearest">
                                <input type="text" placeholder="dd-mm-yyyy hh:mm" class="form-control datetimepicker-input" name="roster_close" data-target="#roster_close" data-toggle="datetimepicker" 
                                    value="<?php echo date('d-m-Y H:i', strtotime($roster->time_close)); ?>" required pattern="^\d{2}-\d{2}-\d{4} \d\d:\d\d$">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" data-target="#roster_close" data-toggle="datetimepicker"><i class="fas fa-calendar-alt"></i></button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-md-2">
                    <div class="col-md-6 pr-lg-4 pr-xl-5">
                        <div class="form-group row no-gutters align-items-center">
                            <label for="roster_start" class="col-4 col-form-label">Trạng thái</label>
                            <div class="col-8">
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
                                <a href="#"><span class="status-roster {{'badge ' . $bgColor}}">{{$roster->status_name}}</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                @if(empty($disabled) && (auth()->user()->isAdmin() || $roster->isAuthor()))
                    <div class="row mb-3">
                        <div class="col-12">
                        <button class="btn btn-success" id="add-row">
                            <i class="fas fa-plus"></i>
                            Thêm ca làm việc
                        </button>
                        </div>
                    </div>
                @endif

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
                                            <div class="table-roster__cell d-flex flex-column align-items-center justify-content-center" data-id="{{ $day->id }}">
                                                <div>
                                                    <span>{{$day->user_shifts_count}}/{{ $day->amount }}</span>
                                                </div>
                                                <div class="table-roster__cell__action">
                                                    @if(auth()->user()->isAdmin() || (auth()->user()->isManager() && auth()->user()->id === $roster->user_created_id))
                                                    <a href="#" data-action="edit" class="btn-edit-shift" data-id="{{$day->id}}"><i class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                </div>
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
                <button type="submit" class="btn btn-success" id="btn-submit">Lưu</button>
            </div>
        </form>
    </div>
</div>
@include('modal.shift-time')
@include('modal.shift')
@include('modal.create-row-shift')
@include('modal.register-shift')
@include('modal.remove-shift')
<script type="text/javascript">
    $(document).ready(function () {
        const DATE = {
            0: 'Chủ nhật',
            1: 'Thứ 2',
            2: 'Thứ 3',
            3: 'Thứ 4',
            4: 'Thứ 5',
            5: 'Thứ 6',
            6: 'Thứ 7',
        };
        // opened date of roster registration
        $('#roster_begin').datetimepicker({
          locale: "vi",
          format: 'DD-MM-YYYY HH:mm',
          sideBySide: true,
        });

        // closed date of roster registration
        $('#roster_close').datetimepicker({
          locale: "vi",
          format: 'DD-MM-YYYY HH:mm',
          sideBySide: true,
        });

        const isStaff = "{{ auth()->user()->isStaff() }}";
        const isAuthor = "{{ $roster->isAuthor() }}";
        const isClosed = "{{ $disabled }}";
        let dayStart = new Date("{{$roster->day_start}}");
        let dayWeekStart = dayStart.getDay();
        if(dayStart && dayWeekStart){
            let colDateEles =  $('#roster-table th').splice(2);
            let dayWeekBegin = dayWeekStart;
            for(let col of colDateEles){
                $(col).text(DATE[dayWeekBegin]);
                dayWeekBegin++;
                if(dayWeekBegin > 6) {
                    dayWeekBegin = 0;
                }
            }
        }

        $('.btn-edit-shift').on('click', function(){
            loading('show');
            const id = $(this).attr('data-id');
            const modeEdit = $(this).attr('data-action') === 'edit' ? true : false;
            if(!id) return;
            getDataShift(id).then(res => {
                loading('hide');
                if(res.Status === 'Success'){
                    if(modeEdit) 
                        editModeShiftModal();
                    else 
                        viewModeShiftModal();
                    $('#shift-modal').modal('show');
                    setDataShift(res.Data);
                } else {
                    alert('Error');
                }
            });
        })

        function viewModeShiftModal(){
            $('#shift-modal .modal-footer').css('display', 'none');
        }

        function editModeShiftModal(){
            $('#shift-modal .modal-footer').css('display', 'flex');
        }

        function getDataShift(idShift){
            let url = "{{route('getShiftById', ':id')}}";
            url = url.replace(':id', idShift);

            const options = {
                url: url,
                method: 'GET'
            }
            return $.ajax(options);
        }

        function setDataShift(data){
            const form = $('#shift-form');
            let weekday  = new Date(data.date).getDay();
            let date =  weekday === 0 ? `Chủ nhật` : `Thứ ${weekday + 1}`;
            let time =  ` ${data.time_start.slice(0, -3)} - ${data.time_finish.slice(0, -3)}`;

            $('#shift-modal').find('.title').text(date + time);
            form.find('.amount').val(data.amount);
            form.find('.status').val(data.status);
            $('#btn-save-shift').attr('data-id', data.id);

            //table
            let lengthUser = data.user_shifts.length;
            if(lengthUser){
                form.find('table').css('display', 'table');
                form.find('tbody').empty();
                let content = '';
                for(let i = 0 ; i < lengthUser; i++){
                    let userShift = data.user_shifts;
                    content += '<tr>' +
                        `<th scope="row">${i + 1}</th>`+
                        `<td>${userShift[i].user.first_name}</td>`+
                        `<td>${userShift[i].created_at ? userShift[i].created_at : ''}</td>`+
                        `<td>${userShift[i].note??''}</td>`+
                        '</tr>';
                    console.log(content);
                }
                form.find('tbody').html(content);
            } else {
                form.find('table').css('display', 'none');
            }
        }

        $('#btn-save-shift').click(function(){
            loading('show');
            let amount = $('#shift-form .amount').val();
            let status = $('#shift-form [name="status"]').val();
            let btnSave = $(this);
            let idShift = btnSave.attr('data-id');
            updateAmountShift(idShift, amount, status).then(res => {
                loading('hide');
                if (res.Status === 'Success') {
                    toastr.success(res.Message);
                    $('#shift-modal').modal('hide');
                    // updateStatusUI(idShift, status);
                    updateInfoShift(idShift, status, 0, amount);
                    btnSave.attr('');
                } else {
                    toastr.error(res.Message);
                }
            });
        })
        
        function updateAmountShift(idShift, amount, status) {
            let url = "{{route('updateAmountShift', ':id')}}";
            url = url.replace(':id', idShift);

            const options = {
                url: url,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    amount,
                    status
                }
            }
            return $.ajax(options);
        }

        function updateStatusUI(idShift, status) {
            let shiftClass = 'shift_' + idShift;
            let newClass = shiftClass + ' text-dark';
            switch(status) {
                case '1':
                    newClass += ' bg-success';
                    break;
                case '2':
                    newClass += ' bg-danger';
                    break;
                case '3':
                    newClass += ' bg-dark';
                    break;
                default:
                    newClass += ' text-dark';
            }
            let shiftDom = $('.' + shiftClass);
            shiftDom.removeClass();
            shiftDom.addClass(newClass);
        }

        $('.shift-row').on('click', function(){
            if(!isAuthor || isClosed) return;
            $('#shift-time-modal').modal('show');
            let data = JSON.parse($(this).closest('tr').attr('data-shift'));
            $('#shift-time-modal #shift-time-form').find('[name="shift_time"]').val(data.time_start + ' - ' + data.time_finish);
            $('#shift-time-modal #shift-time-form').find('[name="shift_start"]').val(data.time_start.slice(0, -3));
            $('#shift-time-modal #shift-time-form').find('[name="shift_finish"]').val(data.time_finish.slice(0, -3));
            $('#shift-time-modal #shift-time-form').find('[name="type"]').val(data.user_type_id);
            $('#shift-time-modal').find('#btn-del-shift').attr('data-id', data.id);
        });

        $('#btn-save-shift-time').click(function(e){
            if (checkValidateHTML('shift-time-form')) {
                e.preventDefault();
                loading('show');
                let data = $('#shift-time-form').serializeArray();
                let objData = arrDataToObject(data);
                
                updateTimeShift(objData).then(res => {
                    if(res.Status === 'Success') {
                        $('#shift-time-modal').modal('hide');
                        loading('hide');
                        toastr.success(res.Message);
                        setTimeout(() => {
                            if(res.Status === 'Success') {
                                location.reload();
                            }
                        }, 500)
                    } else {
                        loading('hide');
                        toastr.error(res.Message);
                    }
                });
            }
        });

        function updateTimeShift(objData){
            let url = "{{route('updateTimeShift')}}";

                const options = {
                url: url,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                   ...objData
                },
                error: (res) => {
                    loading('hide');
                    toastr.error('Error!');
                    console.error(res.message);
                }
            }
            return $.ajax(options);
        }

        //add-shift
        $('#add-row').click(function(){
            $('#shift-form').trigger('reset');
            $('#create-row-shift').modal('show');
            $('#btn-del-row').css('display', 'none');
        });

        //add new shift row
        $('#btn-add-row').click(function(e){
            //TODO: error check validate
            if (checkValidateHTML('shift-form')) {
                e.preventDefault();
                let data = $('#create-row-shift #shift-form').serializeArray();
                let objData = arrDataToObject(data);
                const url = "{{route('addShift')}}";
                const options = {
                    url,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        timeStart: '{{$roster->day_start}}',
                        idRoster: '{{$roster->id}}',
                    ...objData
                    },
                    success: function(res) {
                        if(res.Status === 'Success') {
                            // location.reload();
                        }
                        $('#create-row-shift').modal('hide');
                    },
                    error: function(err) {
                        console.error(err.message);
                    }
                }
                $.ajax(options);
            }
        });

        //add new row
        $('#btn-del-shift').click(function(){
            let shiftID = $(this).attr('data-id');
            if(!shiftID) return;
            const url = "{{route('delShift')}}";
            const options = {
                url,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    shiftID
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

        });

        function updateInfoShift(id, status, amountRegister, amount) {
            let bgColor = {
                0: 'bg-warning',
                1: 'bg-success',
                2: 'bg-danger',
                3: 'bg-dark',
            }
            let shiftDOM = $(`.shift_${id}`);
            //update data-state
            shiftDOM.attr('data-state', status === 0 ? 'isRegistered' : '');
            let className = shiftDOM.attr('class');
            className = className.replace(/bg-\w+\s/, `${bgColor[status]} `);
            shiftDOM.attr('class', className);
            let text = $('span', shiftDOM).text();
            text = text.replace(/^\d/, +text[0] + amountRegister);
            if(amount) {
                text = text.replace(/\d$/, amount);
            }
            $('span', shiftDOM).text(text);
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
        //Staff's event

        //open modal register
        $('.shift-date').not( ".btn-edit-shift").on('click', function(){
            if(!isStaff || isClosed) return;
            let idShift = $(this).attr('data-id');
            let timeShift = getTimeShift(this);
            if(!idShift) return;
            let isRegistered = $(this).attr('data-state');
            let inputDOM = $('#form-register').find('input');
            inputDOM.val('');
            //add text
            $('.form-register').find('span').text(timeShift);
            if(isRegistered === 'isRegistered') {
                $('#remove-shift-modal').modal('show');
                $('#remove-shift').attr('data-id', idShift);
            } else {
                $('#register-shift-modal').modal('show');
                $('#register-shift').attr('data-id', idShift);
            }
        })

        function getTimeShift(cursor){
            let dayWeek = $(cursor).attr('class').match(/day_\d/)[0].slice(-1);
            let dataStr = $(cursor).closest('tr').attr('data-shift');
            if(!dataStr ||!dayWeek) return;
            let data = JSON.parse(dataStr);
            dayWeek = dayWeek === '6' ? 0 : +dayWeek + 1;
            return `${DATE[dayWeek]} (${data.time_start.slice(0, -3)} - ${data.time_finish.slice(0, -3)})`;
        }
        
        $('#register-shift').click(function(){
            let idShift = $(this).attr('data-id');
            if(!idShift) return;
            loading('show');
            registerShift(idShift).then(function(res){
                loading('hide');
            });
        })
        
        function registerShift(shiftID) {
            if(!shiftID) return;
            let url = "{{route('registerShift', ':id')}}";
            url = url.replace(':id', shiftID);
            let note = $('#form-register').find('[name=note]');
            const options = {
                url,
                method: 'GET',
                data: note,
                success: function(res) {
                    if(res.Status === 'Success') {
                        toastr.success(res.Message);
                        updateInfoShift(res.Data.id, 0, 1);
                    } else {
                        updateInfoShift(res.Data.id, res.Data.status, 0);
                        toastr.error(res.Message);
                    }
                    $('#register-shift-modal').modal('hide');
                },
                error: function(err) {
                    loading('hide');
                    toastr.error('Error!');
                    console.error(err.message);
                }
            }
            return $.ajax(options);
        }

        $('#remove-shift').click(function(){
            let idShift = $(this).attr('data-id');
            if(!idShift) return;
            loading('show');
            removeShift(idShift).then(function(res){
                loading('hide');
            });
        })

        function removeShift(shiftID) {
            if(!shiftID) return;
            let url = "{{route('removeShift', ':id')}}";
            url = url.replace(':id', shiftID);
            const options = {
                url,
                method: 'GET',
                success: function(res) {
                    if(res.Status === 'Success') {
                        toastr.success(res.Message);
                        updateInfoShift(shiftID, 1, -1);
                    } else {
                        toastr.error(res.Message);
                    }
                    $('#remove-shift-modal').modal('hide');
                },
                error: function(err) {
                    toastr.error(res.Message);
                    console.error(err.message);
                }
            }
            return $.ajax(options);
        }

        $('#btn-submit').on('click', function(e) {
            if(!checkValidateHTML('form-update')) {
                return;
            }
            loading('show');
            e.preventDefault();
            const url = "{{route('updateTimeRegister')}}";
            const options = {
                url,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    //TODO: check validate time
                    timeBegin: $('[name=roster_begin]').val(),
                    timeClose: $('[name=roster_close]').val(),
                    idRoster: '{{$roster->id}}',
                },
                success: function(res) {
                    loading('hide');
                    if(res.Status === 'Success') {
                        changeStatusRoster(res.statusRoster);
                        toastr.success(res.Message);
                    } else {
                        toastr.error(res.Message);
                    }
                },
                error: function(err) {
                    loading('hide');
                    toastr.error('Error');
                    console.error(err.message);
                }
            }
            $.ajax(options);
        })

        function changeStatusRoster(status) {
            let eleStatus = $('.status-roster');
            let text = '', bgColor = '';
            switch(status){
                case 1:
                    bgColor = 'badge-warning';
                    text = 'pending';
                    break;
                case 2:
                    bgColor = 'badge-success';
                    text = 'open';
                    break;
                case 3:
                    bgColor = 'badge-dark';
                    text = 'closed';
                    break;
            }
            let newClass= `status-roster badge ${bgColor}`;
            eleStatus.text(text);
            eleStatus.attr('class', newClass);
        }
    });
</script>
@endsection