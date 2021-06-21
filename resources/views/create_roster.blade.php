@extends('master')
@include('header')
@section('content')
<div class="row container-create-roster">
  <div class="col-sm-12">
  <div class="card">
    <div class="card-header">
      <div class="card-header__icon">
        <img alt="alt text" src="{!! asset('image/roster.svg') !!}">
      </div>
      Create roster
    </div>
    <div class="card-body">
      <div class="row mb-md-3">
        <div class="col-md-6 pr-lg-4 pr-xl-5">
          <div class="form-group row no-gutters">
            <label for="roster_start" class="col-xl-4 col-form-label"><span class="text-danger">*</span>&nbsp;Ngày bắt đầu</label>
            <div class="col-xl-8">
              <div class="input-group date" id="roster_start" data-target-input="nearest">
                <input type="text" placeholder="yyyy-mm-dd" class="form-control datetimepicker-input" name="roster_start" data-target="#roster_start" data-toggle="datetimepicker" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d'))); ?>">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="button" data-target="#roster_start" data-toggle="datetimepicker"><i class="fas fa-calendar-alt"></i></button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 pl-lg-4 pl-xl-5">
          <div class="form-group row no-gutters">
            <label for="roster_end" class="col-xl-4 col-form-label"><span class="text-danger">*</span>&nbsp;Ngày kết thúc</label>
            <div class="col-xl-8">
              <div class="input-group date" id="roster_end">
                <input type="text" placeholder="yyyy-mm-dd" class="form-control" name="roster_end" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d'). ' + 7 days')); ?>" disabled/>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mb-md-3">
        <div class="col-md-6 pr-lg-4 pr-xl-5">
          <div class="form-group row no-gutters">
            <label for="roster_begin" class="col-xl-4 col-form-label"><span class="text-danger">*</span>&nbsp;Ngày giờ mở đăng kí</label>
            <div class="col-xl-8">
              <div class="input-group date" id="roster_begin" data-target-input="nearest">
                <input type="text" placeholder="yyyy-mm-dd hh:mm" class="form-control datetimepicker-input" name="roster_begin" data-target="#roster_begin" data-toggle="datetimepicker">
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
                <input type="text" placeholder="yyyy-mm-dd hh:mm" class="form-control datetimepicker-input" name="roster_close" data-target="#roster_close" data-toggle="datetimepicker">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="button" data-target="#roster_close" data-toggle="datetimepicker"><i class="fas fa-calendar-alt"></i></button>
                </div>
              </div>
            </div>
          </div>
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
        <tbody></tbody>
      </table>
      <div class="row">
        <div class="col-12">
          <button class="btn btn-success" id="add-row">
            <i class="fas fa-plus"></i>
            Create roster
          </button>
        </div>
      </div>
    </div>
</div>
@include('modal.create-row-shift');

<script type="text/javascript">
    const dataUserType = {!! json_encode($userTypes) !!};
    const USER_TYPE = dataUserType.reduce((a,b) => {
                        return {
                                        ...a,
                                        [b.id]: b.name
                                };
                        }, {});
    $(document).ready(function () {
      /**** format datepicker ****/

        // start date of roster
        $('#roster_start').datetimepicker({
          format: 'YYYY-MM-DD',
          locale: 'vi',
        });

        // opened date of roster registration
        $('#roster_begin').datetimepicker({
          locale: "vi",
          format: 'YYYY-MM-DD HH:mm',
          // inline: true,
          sideBySide: true,
        });

        // closed date of roster registration
        $('#roster_close').datetimepicker({
          locale: "vi",
          format: 'YYYY-MM-DD HH:mm',
          // inline: true,
          sideBySide: true,
        });

        $("[name='roster_start']").trigger("change");
        const dataCopy = {!! json_encode($data) !!};
        //process apply data
        if(dataCopy) {
            let data = formatDataRoster(dataCopy);
            localStorage.setItem('dataRoster', JSON.stringify(data));
            data.forEach(function(item) {
                addRowHtml(item);
            })
        } else {
            localStorage.setItem('dataRoster', "[]");
        }

        function formatDataRoster(data){
            let rs = [];
            for(let i = 0; i < data.length / 7; i++) {
                let item = {};
                for(let j = 0; j < 7; j++) {
                    let index = i*7 + j;
                    item['shift_finish'] = data[index]['time_finish'];
                    item['shift_start'] = data[index]['time_start'];
                    item['type'] = data[index]['user_type_id'];
                    item['id'] = data[index]['id'];
                    item['day_' + j] = data[index]['amount'];
                }
                rs.push(item);
            }
            return rs;
        }

        $("body").on('change', "[name='roster_start']", function(){
            let dayStart = new Date($(this).val());
            $('[name="roster_end"]').val(moment(dayStart).add(7, 'days').format('YYYY-MM-DD'));
            let dayWeekStart = dayStart.getDay();
            //if(dayWeekStart === 1) return;
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
            console.log(dataRow);
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
          $('#roster-table tbody').after(rowHtml);
        }

        function setDataRow(data){
          const type = USER_TYPE;
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
          const url = "{{ route('createRoster') }}";
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
              if(res.Status === 'Success' && res.rosterID) {
                let urlRoster = "{{ route('singleRoster', ':id') }}";
                urlRoster = urlRoster.replace(':id', res.rosterID);
                location.href = urlRoster;
              }
              console.log(res);
            },
            error: (res) => {
              console.error(res.message);
            }
          }
          $.ajax(options);
        });
    });
</script>
@endsection