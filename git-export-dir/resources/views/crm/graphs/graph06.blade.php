<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">{{__('Leads Statistics Pie Chart')}}</h5>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <p class="text-center">
            </p>

            <div class="chart">
              <label for="">
              </label>
              <div id="graph06" class="graph6 rounded"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>


{{-- Script section for this page --}}
@section('script_graph06')
  <script src="{{asset('js/echarts-en.min.js')}}"></script>
  <script src="{{asset('echarts/theme/azul.js')}}"></script>
  
  <script type="text/javascript">var g6_poorfit_leads = {{@$poorfit_leads}};</script>
  <script type="text/javascript">var g6_pending_leads = {{@$pending_leads}};</script>
  <script type="text/javascript">var g6_won_leads = {{@$won_leads}};</script>
  <script type="text/javascript">var g6_dead_leads = {{@$dead_leads}};</script>
  <script src="{{asset('js/graph6.js')}}"></script> 
@endsection