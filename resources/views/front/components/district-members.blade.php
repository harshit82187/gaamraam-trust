
@if($members->isNotEmpty())
    @foreach($members as $member)
        <div class="swiper-slide">
            <div class="member-cardss" style="height:100%;">
                <div class="student-image-block mb-1">
                    @if($member->profile_image)
                        <img src="{{ asset($member->profile_image) }}" alt="Image" />
                    @else
                        <img src="{{ asset('front/images/boy.png') }}" alt="Default" />
                    @endif
                </div>
                <h3 class="pt-1">{{ $member->name ?? 'N/A' }}</h3>
                <p class="mb-0">Social Point :- {{ $member->points ?? '0' }}</p>
                <p class="mb-0">Member Id :- {{ $member->id }}</p>
            </div>
        </div>
    @endforeach
@else
    <div class="w-100 text-center py-4">
        <strong class="text-danger">No members found for this district </strong>
    </div>
@endif

