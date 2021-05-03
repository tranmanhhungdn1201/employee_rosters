@extends('master')
@include('header')
@section('content')
<div class="container container-content">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Create roster</h1>
    </div>
    <div class="roster">
        <div class="roster-time">
            <div class="row justify-content-center align-self-center">
                <input type="date" class="form-control col-3 m-3" name="roster_start" value="2021-02-28"/>
                <div class="">
                    <p class="roster-time-line">-</p>
                </div>
                <input type="date" class="form-control col-3 m-3" name="roster_end" value="2021-03-05"/>
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
                <tr>
                    <td scope="row">
                        <button class="form-control" id="add-row">Thêm</button>
                    </td>   
                    <td colspan="8">
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="roster-action">
            <div class="roster-time">
                <div class="row align-self-center">
                    <input type="datetime-local" class="form-control col-2 m-3" name="roster_begin"/>
                    <div class="">
                        <p class="roster-time-line">-</p>
                    </div>
                    <input type="datetime-local" class="form-control col-2 m-3" name="roster_close"/>
                    <div class="action col-3">
                        <button class="btn btn-success btn-submit" id="btn-submit">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('modal.create-row-shift');
<script type="text/javascript">
    $(document).ready(function () {
        localStorage.setItem('dataRoster', "[]");
        $('#roster-table>tbody').on('click', 'tr', function(){
            let id = $(this).attr('data-id');
            if(!id) return;
            $('#create-row-shift').modal('show');
            $('#btn-add-row').attr('data-id', id);
            $('#btn-add-row').attr('data-type', '1');

            $('#btn-del-row').css('display', 'block');
            $('#btn-del-row').attr('data-id', id);
            setData(id);
        });

        $('#add-row').click(function(){
            $('#create-row-shift').modal('show');
            $('#shift-form input').val(0);
            $('#btn-add-row').attr('data-id','');
            $('#btn-add-row').attr('data-type', '');
            $('#btn-del-row').css('display', 'none');
        });

        //add new row
        $('#btn-add-row').click(function(){
            let typeAction = $(this).attr('data-type');
            let data = $('#shift-form').serializeArray();
            let objData = arrDataToObject(data);
            objData.id = Date.now();
            let dataRoster = JSON.parse(localStorage.getItem('dataRoster'));
            if(!typeAction) {
                localStorage.setItem('dataRoster', JSON.stringify([...dataRoster, objData]));
                addRowHtml(objData);
            } else {
                let id = $(this).attr('data-id');
                let index = dataRoster.findIndex(data => data.id === +id);
                dataRoster.splice(+index, 1, objData);
                localStorage.setItem('dataRoster', JSON.stringify([...dataRoster]));
                let assignRow = $('#roster-table tbody tr[data-id="'+ id +'"]');
                assignRow.attr('data-id', objData.id);
                let contentRow = setDataRow(objData);
                assignRow.html(contentRow);
            }
            $('#create-row-shift').modal('hide');
        });

        //remove row
        $('#btn-del-row').click(function(){
            let id = $(this).attr('data-id');
            let dataRoster = JSON.parse(localStorage.getItem('dataRoster'));
            let index = dataRoster.findIndex(data => data.id === +id);
            dataRoster.splice(+index, 1);
            localStorage.setItem('dataRoster', JSON.stringify([...dataRoster]));
            let assignRow = $('#roster-table tbody tr[data-id="'+ id +'"]');
            assignRow.remove();
            $(this).attr('data-id', '');
            $('#create-row-shift').modal('hide');
        });

        function setData(id){
            let dataRoster = JSON.parse(localStorage.getItem('dataRoster'));
            let dataRow = dataRoster.find(data => data.id === +id);
            let formRoster = $('#shift-form');
            for(let name in dataRow){
                formRoster.find(`[name="${name}"]`).val(dataRow[name]);
            }
        }

        function addRowHtml(data){
            let contentRow = setDataRow(data);
            let rowHtml = '<tr data-id="'+ data.id +'">' +
                            contentRow +
                        '</tr>';
            $('#roster-table tbody tr:last').after(rowHtml);
        }

        function setDataRow(data){
            const type = {
                '0':  'Lễ tân',
                '1':  'Phục vụ',
                '2':  'Giữ xe',
            };
            return  '<td class="shift_start shift_finish">' + data.shift_start + '-' + data.shift_finish + '</td>' +
                    '<td class="type">' + type[data.type] + '</td>' +
                    '<td class="day_0">' + data.day_0 + '</td>' +
                    '<td class="day_1">' + data.day_1 + '</td>' +
                    '<td class="day_2">' + data.day_2 + '</td>' +
                    '<td class="day_3">' + data.day_3 + '</td>' +
                    '<td class="day_4">' + data.day_4 + '</td>' +
                    '<td class="day_5">' + data.day_5 + '</td>' +
                    '<td class="day_6">' + data.day_6 + '</td>'
        }

        $('#btn-submit').click(function(){
            const url = window.location.href + 'rosters';
            const dataRoster = JSON.parse(localStorage.getItem('dataRoster'));
            if(!dataRoster)  return;
            const data = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                dataRoster,
                timeStart: {
                    timeStart: $('[name="roster_start"]').val(),
                    timeFinish: $('[name="roster_end"]').val(),
                },
                timeOpen: {
                    timeOpen: $('[name="roster_begin"]').val(),
                    timeClose: $('[name="roster_close"]').val(),
                }
            };
            const options = {
                url: url,
                method: 'POST',
                data: data,
                success: (res) => {
                    console.log(res);
                },
                error: (res) => {
                    console.error(res.message);
                }
            }
            $.ajax(options);
        })

        $(".roster-time [name='roster_start']").change(function(){
            alert('oke');
            let dayStart = new Date($(this).val());
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
        });
    });

</script>
@endsection