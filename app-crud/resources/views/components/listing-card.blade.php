{{--รับค่าจาก listing จาก view--}}
@props(['listing'])

<x-card>
    <div class="flex">
        <img class="hidden w-48 mr-6 md:block" src="{{$listing->logo ? asset('storage/'.$listing->logo) : asset('images/no-image.png')}}" alt="" />
        {{--มีการเช็คว่าถ้่า $listing->logo มีให้แสดงรูป แต่่ถ้าไม่มีให้เช็ต no-image เป็น default --}}
        <div>
            <h3 class="text-2xl">
                <a href="/listing/{{$listing->id}}">{{$listing->title}}</a>
            </h3>
            <div class="text-xl font-bold mb-4">{{$listing->company}}</div>
            <x-listing-tags :tagsCsv="$listing->tag" />
            <div class="text-lg mt-4">
                <i class="fa-solid fa-location-dot"></i>
                {{$listing->location}}
            </div>
        </div>
    </div>
</x-card>
