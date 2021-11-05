<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <script type="text/javascript" src="assets/jquery.min.js"></script>
    <script type="text/javascript" src="assets/moment.min.js"></script>
    <script type="text/javascript" src="assets/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/daterangepicker.css" />
    <script src="assets/Chart.min.js"></script>
    <body>
        <input type="text" name="datefilter" value="" />

        <script type="text/javascript">
            $(function () {
                var dates = '';
                ajaxcall(dates);
                $('input[name="datefilter"]').daterangepicker({
                    autoUpdateInput: false,
                    timePicker: true,
                    startDate: '2019/04/01', endDate: '2019/04/05',
                    locale: {
                        format: 'YY/M/DD hh:mm'
                    }
                });

                $('input[name="datefilter"]').on('apply.daterangepicker', function (ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD hh:mm:ss') + ' - ' + picker.endDate.format('YYYY-MM-DD hh:mm:ss'));
                    dates = {s: picker.startDate.format('YYYY-MM-DD hh:mm:ss'), e: picker.endDate.format('YYYY-MM-DD hh:mm:ss')};
                    $('#myChart').remove();
                    ajaxcall(dates);
                });

                $('input[name="datefilter"]').on('cancel.daterangepicker', function (ev, picker) {
                    $(this).val('');
                });
                function ajaxcall(dates) {
                    $.ajax({
                        url: 'get.php',
                        data: dates,
                        dataType: 'json',
                        success: function (e) {
                            $('body').append('<canvas id="myChart" style="width:100%;"></canvas>');
                            var xValues = [];
                            var yValues = [];
                            var length = e.length;
                            for (var i = 0; i < length; i++) {
                                xValues.push(e[i]['d']);
                                yValues.push(e[i]['p']);
                            }
                            new Chart("myChart", {
                                type: "line",
                                data: {
                                    labels: xValues,
                                    datasets: [{
                                            fill: false,
                                            borderColor: "rgba(0,0,255,0.6)",
                                            backgroundColor: 'rgba(0,0,255,1)',
                                            data: yValues
                                        }]
                                },
                                options: {
                                    legend: {display: false},
                                    title: {
                                        display: true,
                                        text: "PH Chart"
                                    }
                                }
                            });
                        }
                    });
                }
            });
        </script>
        <canvas id="myChart" style="width:100%;"></canvas>



    </body>
</html>