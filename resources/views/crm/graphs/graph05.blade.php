<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">{{__('Monthly Avg Won Report')}}</h5>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>

          
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <p class="text-center">
              <strong>{{__('Leads')}}: {{__('Start of')}}, {{@$thisYear}} - {{__('end of')}}, {{@$thisYear}}</strong>
            </p>
            
            <div class="chart">
              <label for="">
                {{__('x-axis = Win percentage of the month, y-axis = Months')}}
              </label>
              <div id="graph05" class="graph5 rounded"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


{{-- Script section for this page --}}
@section('script_graph05')
  <script src="{{asset('js/echarts-en.min.js')}}"></script>
  <script src="{{asset('echarts/theme/azul.js')}}"></script>
  <script type="text/javascript">var monthly_leads_avg = {{@$monthly_leads_avg}};</script>
  <script src="{{asset('js/graph5.js')}}"></script>    
@endsection