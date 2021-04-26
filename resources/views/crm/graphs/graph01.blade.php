
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">{{__('Monthly Recap Report')}}</h5>
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
              <strong>{{__('Leads')}}: {{__('Start of')}}, {{@$thisYear}} - {{__('end of')}}, {{@$thisYear}}</strong>
            </p>

            <div class="chart">
              <!-- Sales Chart Canvas -->
              <div id="graph01" class="graph1 rounded"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>

@section('script_graph01')
  <script src="{{asset('js/echarts-en.min.js')}}"></script>
  <script src="{{asset('echarts/theme/westeros.js')}}"></script> 
  
  <script type="text/javascript">var m_total_leads = {{@$m_total_leads}};</script>
  <script type="text/javascript">var m_pending_leads = {{@$m_pending_leads}};</script>
  <script type="text/javascript">var m_won_leads = {{@$m_won_leads}};</script>
  <script type="text/javascript">var m_dead_leads = {{@$m_dead_leads}};</script>
  <script type="text/javascript">var m_poorfit_leads = {{@$m_poorfit_leads}};</script>
  <script src="{{asset('js/graph1.js')}}"></script>
@endsection