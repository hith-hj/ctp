<x-master title="{{ __('admin.'.plural($item)) }}">
  <x-breadcrumb :item="$item"></x-breadcrumb>
  <div class="d-flex flex-column-fluid">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  @include('admin.layouts.panels._alerts')
              </div>
              <div class="col-xl-12">
                <form action="{{isset($offer) ? route('admin.updateOffer',['id'=>$offer->id]) : route('admin.storeOffer')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="card p-1">
                    <div class="card-heder m-2 p-2">
                        <h3 class="text-lg {{app()->getLocale() == 'ar' ? 'text-right' : 'text-left'}}">{{__('front.new')}}</h3>
                    </div>
                    <div class="card-body py-1 px-7 {{app()->getLocale() == 'ar' ? 'text-right' : 'text-left'}}">
                        <div class="row">
                            <div class="col-12 px-1">
                                <label>{{__('front.title')}}</label>
                                <input type="text" name="title" class="form-control" placeholder="{{__('front.title')}}"
                                value="{{isset($offer) ? $offer->title : ''}}">
                            </div>
                            <div class="col-12 px-1">
                                <label>{{__('front.description')}} </label>
                                <textarea type="text" name="description" class="form-control" >
                                    {{isset($offer) ? $offer->description : ''}}
                                </textarea>
                            </div>
                            <!--<div class="col-12 px-1">-->
                            <!--    <label>{{__('front.product')}} </label>-->
                            <!--    <select name="product_id" class="form-control ">-->
                            <!--        <option value="">choose</option>-->
                            <!--        {{-- @foreach($products as $product) --}} -->
                            <!--            {{-- <option value="{{$product->id}}" {{isset($offer) && $offer->product_id == $product->id ? 'selected':'' }}>{{$product->name}}</option>--> --}}
                            <!--        {{-- @endforeach --}} -->
                            <!--    </select>-->
                            <!--</div>-->
                            <div class="col-12 px-1">
                                @if(isset($offer))
                                    <x-image :name="'image'" :oldValue="$offer ?? null" :required="true" ></x-image>
                                @else
                                    <x-image :name="'image'" :required="true"></x-image>
                                    <label>dimensions must be w 250px * h 400px</label>
                                @endif
                            </div>     
                            <div class="col-12">
                                <button class="btn btn-success btn-sm form-control" type="submit">
                                  <i class="fa fa-plus"></i> {{ isset($offer) ? __('admin.edit') : __('admin.create')}}
                                </button>
                            </div>
                        </div>
                    </div>
                  </div>
                </form>
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
                
                
                
                