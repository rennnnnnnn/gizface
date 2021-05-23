<div role="tabpanel" class="tab-pane" id="career">
    <div class="nav-tab-content">
        <div class="col-md-12">
            <div class="" style="margin-bottom:10px;">
                <button type="button" class="btn create" id="careerCreate"> <span class="fa fa-plus-circle" aria-hidden="true"></span> 追加する</button>
            </div>
            @if(!empty($careerInfo))
                @foreach($careerInfo as $key => $value)
                <div class="box career-box">
                    <div class="text-right">
                        <button type="button" class="btn edit careerEdit" data-id="{{$value->id}}"> <span class="fa fa-pencil"></span> 編集する</button>
                    </div>
                    <div>
                        @if(!empty($value->to))
                        <p>{{date('Y年m月',strtotime($value->from))}}〜{{date('Y年m月',strtotime($value->to))}}</p>
                        @else
                        <p>{{date('Y年m月',strtotime($value->from))}}〜</p>
                        @endif
                        <button class="btn career-btn" data-career-id="{{$value->id}}" data-profile-id="{{$value->profile_id}}" data-count="{{$key}}"><h3>{{$value->job_title}}</h3><i class="fa fa-chevron-down"></i></button>
                        <div class="panel career-panel career-info">
                            <div class="job-detail">
                                <h4>実装内容</h4>
                                <p>{!! nl2br(e($value->job_detail)) !!}</p>
                            </div>
                            <div class="job-scale">
                                <h4>役割・規模</h4>
                                <p>全体{{$value->team_scale}}名</p>
                            </div>
                            <div class="job-process">
                                <h4>担当工程</h4>
                                <ul>
                                    @if(!is_null($value->process_rq_definition))
                                    <li>{{$value->process_rq_definition}}</li>
                                    @endif
                                    @if(!is_null($value->process_basic_design))
                                    <li>{{$value->process_basic_design}}</li>
                                    @endif
                                    @if(!is_null($value->process_detail_design))
                                    <li>{{$value->process_detail_design}}</li>
                                    @endif
                                    @if(!is_null($value->process_installation))
                                    <li>{{$value->process_installation}}</li>
                                    @endif
                                    @if(!is_null($value->process_interface_test))
                                    <li>{{$value->process_interface_test}}</li>
                                    @endif
                                    @if(!is_null($value->process_integration_test))
                                    <li>{{$value->process_integration_test}}</li>
                                    @endif
                                    @if(!is_null($value->process_op_maintenance))
                                    <li>{{$value->process_op_maintenance}}</li>
                                    @endif
                                </ul>
                            </div>
                            <div class="skill-language skill-ajax" data-count="{{$key}}">

                            </div>
                            <div class="skill-db skill-ajax" data-count="{{$key}}">

                            </div>
                            <div class="skill-os skill-ajax" data-count="{{$key}}">

                            </div>
                            <div class="skill-fw skill-ajax" data-count="{{$key}}">

                            </div>
                            <div class="skill-tool skill-ajax" data-count="{{$key}}">

                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
