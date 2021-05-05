@extends('master')
@include('header')
@section('content')
<div class="container container-content">
    <div class="roster">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Roster</h1>
        </div>
        <div class="roster-time">
            <div class="row justify-content-center align-self-center align-items-center">
                <span class="title">{{$roster->day_start}} - {{$roster->day_finish}}</span>
                <a href="#"><span class="ml-2 badge badge-success">Active</span></a>
            </div>
        </div>
        <table class="table table-bordered table-hover" id="roster-table">
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
                @if(auth()->user()->isAdmin() || (auth()->user()->isManager() && auth()->user()->id === $roster->user_created_id))
                <tr>
                    <td scope="row">
                        <button class="form-control" id="add-row">Thêm</button>
                    </td>
                    <td colspan="8">
                    </td>
                </tr>
                @endif
                @if (is_array($shifts))
                    @foreach($shifts as $key => $shift)
                    <tr data-shift="{{ $shift[0] }}">
                        <td class="shift-row shift_start shift_finish">{{ $key }}</td>
                        <td class="shift-row type">{{ $shift[0]->user_type_id }}</td>
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
                            <td data-state ="{{$state}}" class="{{$bgColor . ' text-white day_' . $indexDay . ' shift_' . $day->id}} shift-date" data-id="{{ $day->id }}">
                                <div class="d-flex justify-content-around" data-id="{{ $day->id }}">
                                    <div>
                                        <span>{{$day->user_shifts_count}}/{{ $day->amount }}</span>
                                    </div>
                                    <div>
                                        @if(auth()->user()->isAdmin() || (auth()->user()->isManager() && auth()->user()->id === $roster->user_created_id))
                                        <a href="#" class="btn-edit-shift" data-id="{{$day->id}}"><i class="fas fa-pencil-alt"></i></a>
                                        @else
                                        <!-- <a href="#" class="btn-view-shift" data-id="{{$day->id}}"><i class="far fa-eye"></i></a> -->
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
        <div class="roster-action">
            <div class="roster-time">
                <div>
                    <span class="roster-time-description">Thời gian đăng ký:</span><br>
                    <span>{{ $roster->time_open }} - {{ $roster->time_close }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@include('modal.shift-time');
@include('modal.shift');
@include('modal.create-row-shift');
@include('modal.register-shift');
@include('modal.remove-shift');
<script type="text/javascript">
    $(document).ready(function () {
        const isStaff = "{{ auth()->user()->isStaff() }}";
        let dayStart = new Date("{{$roster->day_start}}");
        if(dayStart){
            let dayWeekStart = dayStart.getDay();
            if(dayWeekStart === 1) return;
            let colDateEles =  $('#roster-table th').splice(2);
            const DATE = {
               0: 'Chủ nhật',
               1: 'Thứ 2',
               2: 'Thứ 3',
               3: 'Thứ 4',
               4: 'Thứ 5',
               5: 'Thứ 6',
               6: 'Thứ 7',
            };
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
            const id = $(this).attr('data-id');
            if(!id) return;
            getDataShift(id).then(res => {
                if(res.Status === 'Success'){
                    $('#shift-modal').modal('show');
                    setDataShift(res.Data);
                } else {
                    alert('Error');
                }
            });
        })

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

            form.find('.title').text(date + time);
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
                        `<td></td>`+
                        '</tr>';
                    console.log(content);
                }
                form.find('tbody').html(content);
            } else {
                form.find('table').css('display', 'none');
            }
        }

        $('#btn-save-shift').click(function(){
            let amount = $('#shift-form .amount').val();
            let status = $('#shift-form [name="status"]').val();
            let btnSave = $(this);
            let idShift = btnSave.attr('data-id');
            updateAmountShift(idShift, amount, status).then(res => {
                if(res.Status === 'Success') {
                    $('#shift-modal').modal('hide');
                    updateStatusUI(idShift, status);
                    btnSave.attr('');
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
            let newClass = shiftClass + ' text-white';
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
                    newClass += ' text-white';
            }
            let shiftDom = $('.' + shiftClass);
            shiftDom.removeClass();
            shiftDom.addClass(newClass);
        }

        $('.shift-row').on('click', function(){
            $('#shift-time-modal').modal('show');
            let data = JSON.parse($(this).closest('tr').attr('data-shift'));
            $('#shift-time-modal #shift-time-form').find('[name="shift_time"]').val(data.time_start + ' - ' + data.time_finish);
            $('#shift-time-modal #shift-time-form').find('[name="shift_start"]').val(data.time_start);
            $('#shift-time-modal #shift-time-form').find('[name="shift_finish"]').val(data.time_finish);
            $('#shift-time-modal #shift-time-form').find('[name="type"]').val(data.user_type_id);
            $('#shift-time-modal').find('#btn-del-shift').attr('data-id', data.id);
        });

        $('#btn-save-shift-time').click(function(){
            let data = $('#shift-time-form').serializeArray();
            let objData = arrDataToObject(data);

            updateTimeShift(objData).then(res => {
                if(res.Status === 'Success') {
                    $('#shift-time-modal').modal('hide');
                    location.reload();
                }
            });
        });

        function updateTimeShift(objData){
            let url = "{{route('updateTimeShift')}}";

                const options = {
                url: url,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                   ...objData
                }
            }
            return $.ajax(options);
        }
        //add-shift
        $('#add-row').click(function(){
            $('#create-row-shift').modal('show');
            $('#create-row-shift #shift-form input').val(0);
            $('#btn-del-row').css('display', 'none');
        });

        //add new row
        $('#btn-add-row').click(function(){
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
                        location.reload();
                    }
                    $('#create-row-shift').modal('hide');
                },
                error: function(err) {
                    console.error(err.message);
                }
            }
            $.ajax(options);

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
                        alert('oke');
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

        $('.shift-date').not( ".btn-edit-shift").on('click', function(){
            if(!isStaff) return;
            let idShift = $(this).attr('data-id');
            if(!idShift) return;
            let isRegistered = $(this).attr('data-state');
            if(isRegistered === 'isRegistered') {
                $('#remove-shift-modal').modal('show');
                $('#remove-shift').attr('data-id', idShift);
            } else {
                $('#register-shift-modal').modal('show');
                $('#register-shift').attr('data-id', idShift);
            }
        })

        $('#register-shift').click(function(){
            let idShift = $(this).attr('data-id');
            if(!idShift) return;
            registerShift(idShift).then(function(res){
                location.reload();
            });
        })

        function registerShift(shiftID) {
            if(!shiftID) return;
            let url = "{{route('registerShift', ':id')}}";
            url = url.replace(':id', shiftID);
            const options = {
                url,
                method: 'GET',
                success: function(res) {
                    if(res.Status === 'Success') {
                        console.log('Success');
                    }
                    $('#register-shift-modal').modal('hide');
                },
                error: function(err) {
                    console.error(err.message);
                }
            }
            return $.ajax(options);
        }

        $('#remove-shift').click(function(){
            let idShift = $(this).attr('data-id');
            if(!idShift) return;
            removeShift(idShift).then(function(res){
                console.log(res);
                location.reload();
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
                        console.log('Success');
                    }
                    $('#remove-shift-modal').modal('hide');
                },
                error: function(err) {
                    console.error(err.message);
                }
            }
            return $.ajax(options);
        }
    });
</script>
@endsection