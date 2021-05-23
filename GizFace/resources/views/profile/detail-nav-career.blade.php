<div role="tabpanel" class="tab-pane" id="career">
    <div class="nav-tab-content">
        <div class="col-md-12">
            @if(!empty($careerInfo))
                @foreach($careerInfo as $key => $value)
                @if($key === 0)
                <div>
                    @if(!empty($value->to))
                    <p>{{date('Y年m月',strtotime($value->from))}}〜{{date('Y年m月',strtotime($value->to))}}</p>
                    @else
                    <p>{{date('Y年m月',strtotime($value->from))}}〜</p>
                    @endif
                    <h3>{{$value->job_title}}</h3>
                </div>
                <div class="career-info">
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
                    @if(!empty($careerSkillInfo))
                        <div class="skill-language">
                            <h4>使用言語</h4>
                            <ul>
                                @foreach($careerSkillInfo as $value)
                                @if($value->category == '言語')
                                    <li>{{$value->skill}}</li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="skill-db">
                            <h4>DB</h4>
                            <ul>
                                @foreach($careerSkillInfo as $value)
                                @if($value->category == 'DB')
                                    <li>{{$value->skill}}</li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="skill-os">
                            <h4>OS</h4>
                            <ul>
                                @foreach($careerSkillInfo as $value)
                                @if($value->category == 'サーバOS')
                                    <li>{{$value->skill}}</li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="skill-fw">
                            <h4>FW</h4>
                            <ul>
                                @foreach($careerSkillInfo as $value)
                                @if($value->category == 'FW')
                                    <li>{{$value->skill}}</li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="skill-tool">
                            <h4>ツール</h4>
                            <ul>
                                @foreach($careerSkillInfo as $value)
                                @if($value->category == 'ツール')
                                    <li>{{$value->skill}}</li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                @elseif($key > 0)
                <div class="box career-box">
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
                @endif
                @endforeach
            @endif
        </div>
    </div>
</div>
