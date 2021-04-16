@extends('adminlte::page')

@section('plugins.Chartjs', true)
    
@section('title', 'Dashboard')

@section('content_header')
  <div class="row">
    <div class="col-md-6"><h1>Dashboard</h1></div>
    <div class="col-md-6">
        <form method="get">
          <select onchange="this.form.submit()" id="datefilter" name="datefilter" class="float-right">
            <option value="7" @if($dateFilter == 7) selected @endif>Última semana</option>
            <option value="30" @if($dateFilter == 30) selected @endif>Último mês</option>
            <option value="60" @if($dateFilter == 60) selected @endif>Últimos 2 meses</option>
            <option value="90" @if($dateFilter == 90) selected @endif>Últimos 3 meses</option>
          </select>
        </form>
    </div>
  </div>
    
@stop

@section('content')

<div class="row">
    <div class="col-lg-3 col-6">
      <!-- small card -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{$visitsCount}}</h3>

          <p>Visitantes</p>
        </div>
        <div class="icon">
          <i class="far fa-fw fa-eye"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small card -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{$onlineCount}}</h3>

          <p>Online</p>
        </div>
        <div class="icon">
          <i class="far fa-fw fa-user"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small card -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{$pageCount}}</h3>
          <p>Páginas</p>
        </div>
        <div class="icon">
          <i class="far fa-fw fa-sticky-note"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small card -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>{{$userCount}}</h3>
          <p>Usuários Cadastrados</p>
        </div>
        <div class="icon">
          <i class="fas fa-user-plus"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
  </div>




    <div class="row">
      <div class="card card-info col-md-6" style="max-width: 700px;">
        <div class="card-header">
          <h3 class="card-title">Numero de visitas por página</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
          <canvas id="pieChart" style="height: 230px; min-height: 230px; display: block; width: 397px;" width="794" height="460"></canvas>
        </div>
        <!-- /.card-body -->
    </div>

    </div>

    

    <script>

        window.onload = function(){

            let ctx = document.getElementById('pieChart').getContext('2d');

            window.pagePie = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: {!!$chartLabels!!},
                    datasets: [{
                        data: {!!$chartValues!!},
                        backgroundColor: {!!$chartColors!!}
                    }]
                },
                options: {
                    responsive: true,
                    legend: {
                        display: false
                    }
                }
            }); 
        }
    </script>
@stop

@section('css')
    
@endsection

@section('js')
    
@endsection