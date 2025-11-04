@extends('member.layouts.app')
@section('content')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush
@php
    $radius = 50;
    $circumference = 2 * pi() * $radius;
    $offset = $circumference - ($circumference * $rejectedPercentage / 100);
@endphp
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row py-4">
                    <div class="col-md-5">
                        <div class="dashboard-profilee">
                            <h3 class="text-white">Welcome</h3>
                            <h2 class="py-2 text-white">{{ $member->name ?? 'N/A' }} </h2>
                            @if($member->country != null & $member->state != null)
                            <div class="location-from py-3">
                                <span class="text-white"></span>
                            </div>
                            @endif
                            <div class="achivemnent_badge text-center" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#badgeModal">
                                <img src="https://cdn-icons-png.flaticon.com/128/2583/2583434.png" alt="">
                                <h5>Member</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="member_progress_section">
            <div class="row">
                <div class="col-12">
                    <div class="member_progress_level">
                        <div class="task_level_cards">
                            @foreach($levels as $level)
                                <div class="task_cards {{ $point >= $level['points'] ? '' : 'disabled_card' }}">
                                    <img src="https://cdn-icons-png.flaticon.com/128/2583/2583434.png" alt="">
                                    <div class="lock_img">
                                        @if($point >= $level['points'])
                                            <img src="https://cdn-icons-png.flaticon.com/128/5290/5290058.png" class="checked_img" alt="">
                                        @else
                                            <img src="https://cdn-icons-png.flaticon.com/128/641/641693.png" class="locked_img" alt="">
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="progress_label">
                        <div class="left_content">
                            <h5>Social Points: <strong class="d-block">{{ number_format($point) }}</strong></h5>
                        </div>
                        <div class="right_content">
                            <span>{{ $progressPercent == 100 ? 'MAX LEVEL' : 'UNLOCKED' }}</span>
                            <h2>LEVEL: 0{{ $currentLevel }}</h2>
                        </div>
                    </div>

                    <div class="progress_section d-none">
                        <div class="progress_section_label">
                            <span>0%</span>
                            <span>100%</span>
                        </div>
                        <div class="progress" role="progressbar" aria-valuenow="{{ $progressPercent }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" style="width: {{ $progressPercent }}%"></div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <div class="row">
            {{-- Task Rejected --}}
            <div class="col-6 col-md-3 mb-3">
                <div class="progress-card red">
                    <div class="circular">
                        <svg width="100" height="100" class="red rounded-circle">
                            <circle class="circle-bg" cx="50" cy="50" r="40"  />
                            <circle class="circle-progress" cx="50" cy="50" r="40" style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }};" />
                        </svg>
                        <div class="percentage">{{ $rejectedCount }}/{{ $totalTasks }}</div>
                    </div>
                    <div class="title">Task Reject</div>
                </div>
            </div>

            {{-- Task Pending --}}
            <div class="col-6 col-md-3 mb-3">
                <div class="progress-card yellow">
                    <div class="circular">
                        <svg width="100" height="100" class="yellow rounded-circle">
                            <circle class="circle-bg" cx="50" cy="50" r="40" />
                            <circle class="circle-progress" cx="50" cy="50" r="40" style="stroke-dashoffset: {{ 251 - (251 * $pendingPercentage / 100) }};" />
                        </svg>
                        <div class="percentage">{{ $pendingCount }}/{{ $totalTasks }}</div>
                    </div>
                    <div class="title">Task Pending</div>
                </div>
            </div>

            {{-- Task Accepted --}}
            <div class="col-6 col-md-3 mb-3">
                <div class="progress-card green">
                    <div class="circular">
                        <svg width="100" height="100" class="green rounded-circle">
                            <circle class="circle-bg" cx="50" cy="50" r="40" />
                            <circle class="circle-progress" cx="50" cy="50" r="40" style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }};" />
                        </svg>
                        <div class="percentage">{{ $acceptedCount }}/{{ $totalTasks }}</div>
                    </div>
                    <div class="title">Task Accept</div>
                </div>
            </div>

            {{-- Task Updates --}}
            <div class="col-6 col-md-3 mb-3">
                <div class="progress-card blue">
                    <div class="circular">
                        <svg width="100" height="100" class="blue rounded-circle">
                            <circle class="circle-bg" cx="50" cy="50" r="40" />
                            <circle class="circle-progress" cx="50" cy="50" r="40" style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }};" />
                        </svg>
                        <div class="percentage">{{ $taskUpdatesCount }}/{{ $acceptedCount }}</div>
                    </div>
                    <div class="title">Task Update</div>
                </div>
            </div>
        </div>

        
        <div class="row">
            <div class="col-12">
                <table class="mt-5">
                    <thead>
                        <tr>
                            <th style="width:40%">Task</th>
                            <th>Status</th>
                            <th>Progress</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Repeat for each row -->
                        @if(isset($tasks) && $tasks->count())
                            @foreach($tasks as $task)
                                <tr>                           
                                    <td>
                                        <span class="task-title">Task {{ $loop->iteration }}</span>
                                        <span class="task-desc">{{ $task->task ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="status">
                                            <span class="status-dot @if($task->status == 0) status-reject @elseif($task->status == 1) status-accept  @else status-pending  @endif">
                                            </span>
                                            @if($task->status == 0)
                                                Rejected
                                            @elseif($task->status == 1)
                                                Accepted
                                            @else 
                                                Pending
                                            @endif
                                        </div>
                                    </td>
                                    @php 
                                    $updatesCount = $task->taskDetails()->count();
                                    if ($updatesCount == 0) {
                                        $progress = 0;$color = '#d32f2f';
                                    } elseif ($updatesCount >= 1 && $updatesCount <= 10) {
                                        $progress = 25;$color = '#00e5ff';
                                    } elseif ($updatesCount >= 11 && $updatesCount <= 41) {
                                        $progress = 65;$color = '#800020';
                                    } elseif ($updatesCount >= 42 && $updatesCount <= 85) {
                                        $progress = 85; $color = '#4caf50';
                                    } else {
                                        $progress = 100;$color = '#4caf50';
                                    }$task->progress = $progress;
                                    @endphp
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="progress-bar"><div class="progress-fill" style="width: {{ $progress }}%; background-color: {{ $color }}; height: 100%; border-radius: 5px; transition: width 0.5s ease;"></div></div>{{ $task->progress }}%
                                        </div>
                                    </td>
                                    <td>
                                        @if($task->taskDetails->count() > 0)
                                        <a href="{{ url('member/task-update/' . $task->id) }}"><span class="approval">See Updates</span></a>
                                        @else 
                                        <a href="{{ url('member/task-list') }}"><span class="approval">Go To Task Detail</span></a>
                                         
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            @else
                             <tr>
                                <td colspan="5" class="text-danger text-center" >No Task Found!</td>
                            </tr>
                        @endif

                     

                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="badgeModal" tabindex="-1" aria-labelledby="badgeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header pb-2">
        <h5 class="modal-title" id="badgeModalLabel">Badge Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <!-- Badge Table -->
        <table class="table text-center">
          <thead>
            <tr>
              <th>Level</th>
              <th>Badge</th>
              <th>Rank</th>
              <th>Required Points</th>
            </tr>
          </thead>
          <tbody>
            <tr>
                <td>Lv.1</td>
              <td><img src="https://cdn-icons-png.flaticon.com/128/2583/2583434.png" width="32" alt=""></td>
              <td>Supporter</td>
              <td>100</td>
            </tr>
            <tr>
                <td>Lv.2</td>
              <td><img src="https://cdn-icons-png.flaticon.com/128/5406/5406792.png" width="32" alt=""></td>
              <td>Family Member</td>
              <td>20,000</td>
            </tr>
            <tr>
                <td>Lv.3</td>
              <td><img src="https://cdn-icons-png.flaticon.com/128/9540/9540763.png" width="32" alt=""></td>
              <td>Leader</td>
              <td>50,000</td>
            </tr>
            <tr>
                <td>Lv.4</td>
              <td><img src="https://cdn-icons-png.flaticon.com/128/9433/9433085.png" width="32" alt=""></td>
              <td>Builder</td>
              <td>1,00,000</td>
            </tr>
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>
@endsection