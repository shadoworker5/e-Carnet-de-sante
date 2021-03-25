@extends('layouts.app', ['title' => 'Home'])

@section('head_file')
    <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('main_content')
    <div class="row">
        @if(in_array(Auth::user()->user_role, ['root', 'admin', 'supervisor']))
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold"> {{ __('Diagramme des vaccinations') }} </h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" style="text-decoration:none" aria-label="Reload line chart" role="button" id="dropdownMenuLink1"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink1">
                                <div class="dropdown-header"> {{ __("Options") }} </div>
                                <a class="dropdown-item" href="#" onclick="window.location.reload();"> {{ __("Actualiser") }} </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myAreaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold"> {{ __("Répartion des patients selon le genre") }} </h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" style="text-decoration:none" aria-label="Reload pie chart" role="button"  id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header"> {{ __("Options") }} </div>
                                <a class="dropdown-item" href="#" onclick="window.location.reload();"> {{ __("Actualiser") }} </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="myPieChart"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            <span class="mr-2">
                                <i class="fas fa-circle text-success"></i> {{ __("Femme") }}
                            </span>

                            <span class="mr-2">
                                <i class="fas fa-circle text-primary"></i> {{ __("Homme") }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(in_array(Auth::user()->user_role, ['collector']))
            <div class="col-md-3">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Menu
                            </button>
                        </h2>

                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('patient.create') }}"> {{ __('Ajouter un patient') }} </a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('calendar.index') }}"> {{ __('Calendrier des vaccinations') }} </a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#load_data">
                                            <i class="fa fa-download"></i>
                                            {{ __("Charger les données des patients") }}
                                        </a>
                                    </li>
                                    
                                    {{-- <li class="nav-item">
                                        <a class="nav-link text-danger" href="#" onclick="emptyAllData()">
                                            <i class="fa fa-download"></i>
                                            {{ __("Supprimer les données") }}
                                        </a>
                                    </li> --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">
                <div class="card shadow mb-4" id="show_patient_liste">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold"> {{ __("Liste des patients") }} </h6>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive" id="data_patient">
                            <div class="row mb-3" id="search_info">
                                <div class="form-floating col-md-2">
                                    <input type="text" class="form-control" placeholder="Code du patient" id="floatingSearchCode" name="code">
                                    <label for="floatingSearchCode"> {{ __("Code du patient") }} </label>
                                </div>

                                <div class="form-floating col-md-2">
                                    <input type="text" class="form-control" placeholder="Nom du patient" id="floatingSearch" name="search">
                                    <label for="floatingSearch"> {{ __("Nom du patient") }} </label>
                                </div>
                    
                                <div class="form-floating col-md-2">
                                    <input type="date" class="form-control" eholder="Date de naissance" id="floatingBirthday" name="birthday">
                                    <label for="floatingBirthday"> {{ __("Date de naissance") }} </label>
                                </div>
                                
                                <div class="form-floating col-md-2">
                                    <input type="text" class="form-control"  placeholder="Lieu de naissance" id="floatingLocation" name="born_location">
                                    <label for="floatingLocation"> {{ __("Lieu de naissance") }} </label>
                                </div>
                                
                                <div class="form-floating col-md-2">
                                    <input type="text" class="form-control" placeholder="Nom du père" id="floatingFather" name="name_father">
                                    <label for="floatingFather"> {{ __("Nom du père") }} </label>
                                </div>
                                
                                <div class="form-floating col-md-2">
                                    <input type="text" class="form-control" placeholder="Nom de la mère" id="floatingMother" name="name_mother">
                                    <label for="floatingMother"> {{ __("Nom de la mère") }} </label>
                                </div>
                            </div>

                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                    <tr>
                                        <th> {{ __('Code') }} </th>

                                        <th> {{ __('Nom') }} </th>

                                        <th> {{ __('Date de naissance') }} </th>
                                        
                                        <th> {{ __('Lieu de naissance') }} </th>
                                        
                                        <th> {{ __('Nom du père') }} </th>

                                        <th> {{ __('Nom de la mère') }} </th>

                                        <th> {{ __('Action') }} </th>
                                    </tr>
                                </thead>
                                
                                <tbody id="patient_data"></tbody>

                                <tfoot>
                                    <tr>
                                        <th> Code </th>
                                        <th> Nom </th>
                                        <th> Date de naissance </th>
                                        <th> Lieu de naissance </th>
                                        <th> Nom du père </th>
                                        <th> Nom de la mère </th>
                                        <th> Ature </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mb-2 mt-5 text-center">
                    <button class="btn btn-primary" id="open_modal" data-bs-toggle="modal" data-bs-target="#load_data">
                        <i class="fa fa-download"></i>
                        Télécharger les données des patients
                    </button>
                </div>
            </div>
        @elseif(in_array(Auth::user()->user_role, ['guest']))
            <div class="mt-5 mb-2" style="height:379px">
                <div class="col-md-6 offset-md-3">
                    <h3 class="text-center"> {{ __("Afficher mon carnet de santé") }} </h3>
                    @livewire('find-patients')
                </div>
            </div>
        @endif
    </div>

    {{-- Modal pour charger les données --}}
    <div class="modal fade" id="load_data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="example" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Charger les données des patients </h5>
                    <button class="close" type="button" onclick="window.location.reload();" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="form_load_data" novalidate>                        
                        @livewire('choose-region')
                        
                        <button type="submit" id="btn_load_data" onclick="getDataPerLocation()" class="btn btn-primary mt-2 pull-right">
                            <i class="fa fa-download"></i>
                            Charger
                        </button>
                    </form>
                    
                    <div class="" id="error_message"> </div>
                    <div class="mt-3" id="progress_bar"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal" onclick="window.location.reload();"> Fermer </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script_js')
    @if(in_array(Auth::user()->user_role, ['collector']))
        <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>
        <script src="{{ asset('js/form_validate.js') }}"></script>
        <script src="{{ asset('js/load_data.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#dataTable tfoot th').each( function () {
                    var title = $(this).text();
                    $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
                } );
            } );
        </script>
    @endif
    
    @if(in_array(Auth::user()->user_role, ['root', 'admin', 'supervisor']))
        <script>
            let male =  <?=  $genre_count['M'] ?>, 
            female = <?= $genre_count['F'] ?>;
            var ctx = document.getElementById("myPieChart");
            var myPieChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ["Homme", "Femme"],
                    datasets: [{
                    data: [male, female],
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                    hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    },
                    legend: {
                    display: false
                    },
                    cutoutPercentage: 80,
                },
            });

            let vacinate_count = <?= $vacinate_count ?>;
            let months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

            function number_format(number, decimals, dec_point, thousands_sep){
                number = (number + '').replace(',', '').replace(' ', '');
                var n = !isFinite(+number) ? 0 : +number,
                    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                    s = '',
                    toFixedFix = function(n, prec) {
                        var k = Math.pow(10, prec);
                        return '' + Math.round(n * k) / k;
                    };
                // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                }
                if ((s[1] || '').length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1).join('0');
                }
                return s.join(dec);
            }

            var ctx = document.getElementById("myAreaChart");
            var myLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                    label: "Nombre",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: vacinate_count,
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0
                        }
                    },
                    scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            callback: function(value, index, values) {
                                return number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        titleMarginBottom: 10,
                        titleFontColor: '#6e707e',
                        titleFontSize: 14,
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        intersect: false,
                        mode: 'index',
                        caretPadding: 10,
                        callbacks: {
                            label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                            }
                        }
                    }
                }
            });
        </script>
    @endif
@endsection