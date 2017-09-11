<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico?" type="image/x-icon">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Unipark  - система онлайн заказов ЮниПарк</title>

    <!-- Styles -->
    {{--<link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('/adminlte/css/adminlte.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/css/main.css" >
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    {{--<link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css">--}}

    @yield('css')
    @yield('js')

</head>

<body>

<div id="__blaze-root">




    <style media="screen">
        #table-container{
            width: 70%;
            margin-left: 15%;
            border: solid 2px;
        }
        #report-table th, #report-table td {
            border : solid 1px !important;
        }
    </style>
    <style type="text/css" media="print">
        @page
        {
            size:  auto;   /* auto is the initial value */
            margin: 0mm;  /* this affects the margin in the printer settings */
        }

        html
        {
            background-color: #FFFFFF;
            margin: 0px;  /* this affects the margin on the html before sending to printer */
        }

        body
        {
            border: none ;
            margin: 5mm 5mm 5mm 5mm; /* margin you want for the content */
        }
        #report-table th, #report-table td {
            border : solid 1px !important;
        }
        #table-container:{
            width:100%;
        }
    </style>
    <a href="#" class="btn btn-primary" onclick="printDiv('printArea')" id="printPage"><i class="fa fa-print"></i> Печать</a>

    <div id="printArea">
    <table id="table-container">
        <tr>
            <td>
                <table style="width:100%; border-bottom:solid 1px; border-top:solid 1px;" id="printTable">
                    <tr>
                        <td style="width:40%; text-align:center;">
                            БИН  151040002632<br>
                            KZ416200922030000125   (KZT)<br>
                            филиал АО Tengri Bank в г. Астана<br>
                            БИК: TNGRKZKX
                        </td>
                        <td style="width:20%; text-align:center;"><img src="/img/icon_160.png" width="100" height="100"></td>
                        <td style="width:40%; text-align:center;">
                            КАЗАХСТАН, Г. АСТАНА <br>
                            РАЙОН "Есиль",<br>
                            ПР. ТУРАН, дом 7, оф 2
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td><hr style="color:black; font-weight:bold;"></td></tr>
        <tr><td><div style="float:right; margin-right:2%; font-weight:bold; font-size:18px;"></div></td></tr>


        <tr><td></td></tr>
        <tr><td></td></tr>

        <tr>
            <td style="text-align:center;">
                <p style="font-weight:bold; font-size:16px;">ЗАЯВКА № {{$model->id}}</p>
                <p style="font-weight:bold; font-size:16px;">Центральная диспетчерская служба</p>
                <p><input type="text" name="name" style="border:none;"></p>
            </td>
        </tr>
        <tr>
            <td>
                <table style="border:solid 1px;" id="report-table">
                    <tr>
                        <th>Заявка №</th>
                        <th>Дата</th>
                        <th>Время подачи</th>
                        <th>Место подачи</th>
                        <th>Маршрут</th>
                        <th>Примечание</th>
                    </tr>

                    <tr>
                        <td>{{$model->id}}</td>
                        <td>{{date('d.m.Y', strtotime($model->date_start))}}</td>
                        <td style="text-align:center;">{{date('h:i', strtotime($model->date_start))}}</td>
                        <td>{{$model->start_point_text}}</td>
                        <td>{{$model->end_point_text}}</td>
                        <td>
                            <input type="text" name="name" style="border:none;">
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td>
                            <div style="float:left;">
                                <b>Контакты</b> <br>

                            </div>
                            <p style="text-align:left;">

                            </p>
                        </td>
                        <td>

                            <div style="float:right; margin-right:2%;">
                                <b>Исполнитель: {{auth()->user()->fullName}}</b> <br> Дата: {{date('d.m.Y')}}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>

        </tr>
        <tr>

            <td>
                <table>
                    <tr>
                        <td>

                            <b>Директор:</b>
                            <br>
                            <br>
                            Подпись
                        </td>

                        <td>



                        </td>
                    </tr>
                </table>
            </td>

        </tr>
    </table>
    </div>

</div>

<script type="text/javascript">
    function printDiv(divName) {
        console.log(document.getElementById(divName));
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
</body>
</html>