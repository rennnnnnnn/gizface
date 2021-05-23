<div role="tabpanel" class="tab-pane active skill-info" id="skill">
    <div class="nav-tab-content">
        <div class="col-md-6">
            <div class="category-title">
                <h4>言語</h4>
            </div>
            <div>
                <ul class="skill-list">
                    @if(is_array($skillInfo['language']))
                        @foreach($skillInfo['language'] as $skill => $period)
                        <li class="mb-10">
                            <span class="">{{$skill}}　</span> <span class="format-date">{{$period}}</span>
                        </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        <div class="col-md-6" >
            <div class="category-title">
                <h4>フレームワーク</h4>
            </div>
            <div>
                <ul class="skill-list">
                    @if(is_array($skillInfo['fw']))
                        @foreach($skillInfo['fw'] as $skill => $period)
                        <li class="mb-10">
                            <span class="">{{$skill}}　</span> <span class="format-date">{{$period}}</span>
                        </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="nav-tab-content">
        <div class="col-md-6">
            <div class="category-title">
                <h4>役割</h4>
            </div>
            <div>
                <ul class="skill-list">
                    @if(is_array($skillInfo['role']))
                        @foreach($skillInfo['role'] as $skill => $period)
                        <li class="mb-10">
                            <span class="">{{$skill}}　</span> <span class="format-date">{{$period}}</span>
                        </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        <div class="col-md-6" >
            <div class="category-title">
                <h4>DB</h4>
            </div>
            <div>
                <ul class="skill-list">
                    @if(is_array($skillInfo['db']))
                        @foreach($skillInfo['db'] as $skill => $period)
                        <li class="mb-10">
                            <span class="">{{$skill}}　</span> <span class="format-date">{{$period}}</span>
                        </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
    {{-- <div class="nav-tab-content">
        <div class="col-md-6">
            <div class="category-title">
                <h4>その他</h4>
            </div>
            <div>
                <ul class="skill-list">
                    @if(is_array($skillInfo['tool']))
                        @foreach($skillInfo['tool'] as $skill => $period)
                        <li>
                            <span class="">{{$skill}}　</span> <span class="format-date">{{$period}}</span>
                        </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div> --}}
</div>
