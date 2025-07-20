<x-master title="{{ __('admin.'.plural($item)) }}">
  <x-breadcrumb :item="$item"></x-breadcrumb>
  <div class="d-flex flex-column-fluid">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  @include('admin.layouts.panels._alerts')
              </div>
              <div class="col-xl-12">
                
                <div class="card p-2">
                    <div class="card-heder d-flex justify-content-between px-1">
                        <h3 class="text-lg {{app()->getLocale() == 'ar' ? 'text-right' : 'text-left'}}">{{__('front.offers')}}</h3>
                        <a href="{{route('admin.createOffer')}}" class="btn btn-outline-primary">{{__('admin.create')}}</a>
                    </div>
                    <div class="card-body row px-1 py-2 m-0">
                        @forelse ($offers as $offer)
                            <div class="col-sm-12 col-md-6 col-lg-4" style=" 
                                @if(app()->getLocale() == 'ar')
                                    direction:rtl !important;
                                    text-align: justify;
                                @endif ">
                                <div class="border rounded-sm p-2 my-4">
                                    <div class="d-flex align-items-center">
                                        <h2 class="text-lg w-100 px-1 m-0 my-1">
                                           {{ucfirst($offer->title)}} 
                                        </h2>
                                        <div>
                                            <div class="d-flex">
                                                <a href="{{route('admin.createOffer',['id'=>$offer->id])}}" class="mx-auto mt-0 mb-2 px-2">
                                                    <button class="btn p-0" type="button" title="edit">
                                                        <i class="fa fa-edit text-success"></i>
                                                    </button>
                                                </a>
                                                <a href="" class="mx-auto mt-0 mb-2 px-2">
                                                    <button class="btn p-0" type="submit" form="offer-{{$offer->id}}-delete" title="delete">
                                                        <i class="fa fa-trash text-danger"></i>
                                                    </button>
                                                </a>
                                                <form action="{{route('admin.deleteOffer',['id'=>$offer->id])}}" method="post" 
                                                onsubmit="if(confirm('Are you sure?')){this.submit()}else{event.preventDefault();}"
                                                   id="offer-{{$offer->id}}-delete" >@csrf</form>
                                            </div>
                                        </div>
                                    </div>
                                    <p>
                                        {{$offer->description}}
                                    </p>
                                    <div class="text-center">
                                        <img src="{{storageImage($offer->image)}}" width="200px" height="200px" >
                                    </div>
                                </div>
                            </div>
                        @empty
                            <h4 class="alert">{{__('front.nothing found')}}</h4>
                        @endforelse
                    </div>
                </div>
                
              </div>
          </div>
          <!--end::Row-->
          <!--begin::Row-->
      </div>
      <!--end::Container-->
  </div>
  <!--end::Entry-->

  <x-slot name="footer"></x-slot>
</x-master>
