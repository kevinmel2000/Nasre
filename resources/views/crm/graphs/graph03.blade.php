
<div class="row">
  <div class="col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-funnel-dollar"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">{{__('Total Revenue')}}</span>
        <span class="info-box-number">
          {{@$total_revenue}}
        </span>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-funnel-dollar"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">{{__('Pending Leads')}}</span>
        <span class="info-box-number">
          {{@$pending_leads}} ({{number_format(@$pending_leads_avg, 2)}}<small>%</small>)
        </span>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="info-box">
      <span class="info-box-icon elevation-1 bg-info"><i class="fas fa-funnel-dollar"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">{{__('Won Leads')}}</span>
        <span class="info-box-number">
          {{@$won_leads}} ({{number_format(@$won_leads_avg, 2)}}<small>%</small>)
        </span>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-funnel-dollar"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">{{__('Poorfit and Dead Leads')}}</span>
        <span class="info-box-number">
          {{@$dead_leads + @$poorfit_leads}} ({{number_format(@$dead_leads_avg + @$poorfit_leads_avg, 2)}}<small>%</small>)
        </span>
      </div>
    </div>
  </div>

</div>