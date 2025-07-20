<x-master title="{{ __('admin.Inventory') }}">
    <x-breadcrumb item="Inventory"></x-breadcrumb>
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 mt-5">
                    {{-- @include('admin.'.$item.'._table') --}}
                    <div class="card">
                        <div class="card-header">
                            <h4 class="{{app()->getLocale() == 'ar' ? 'text-right' : 'text-left'}}">{{ __('admin.Inventory') }}</h4>
                        </div>
                        <div class="card-body pt-0 pb-3">
                    		<table class="table table-sm">
                    		    <thead class="p-1">
                    		        <tr>
                    		            <th>id</th>
                    		            <th>{{__('product.Product id')}}</th>
                    		            <th>{{__('product.Name')}}</th>
                    		            <th>{{__('product.Quantity')}}</th>
                    		            <th>{{__('product.Status')}}</th>
                    		            <th>{{__('product.Created at')}}</th>
                    		            <th>{{__('product.Actions')}}</th>
                    		        </tr>
                    		    </thead>
                    		    <tbody class="p-1">
                    		        @forelse($inventory as $item)
                        		        <tr>
                        		            <th>{{$item->id}}</th>
                        		            <th>{{$item->product_id}}</th>
                        		            <th>{{$item->product->name ?? ''}}</th>
                        		            <th>{{$item->quantity}}</th>
                        		            <th>{{$item->status}}</th>
                        		            <th>{{$item->created_at}}</th>
                        		            <th>
                        		                <div class="d-flex {{app()->getLocale() == 'ar' ? 'justify-content-end' : 'justify-content-start'}} align-items-center">
                                                    <div>
                                                        <span class="btn btn-sm btn-clean btn-icon btn-hover-success" title="Show" onclick="
                                                            let input = document.getElementById('quantity_item_{{$item->id}}');
                                                            if(input.style.display == 'none'){
                                                                input.style.display = 'contents';
                                                            }else{
                                                                input.style.display = 'none';
                                                            }
                                                            console.log(input);
                                                        ">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <form method="post" action="{{route('admin.deleteInventoryItem',['id'=>$item->id])}}">
                                                            @csrf
                                                            <button class="btn btn-sm btn-clean btn-icon btn-hover-primary mx-2">
                                                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                    <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                        <g id="Stockholm-icons-/-General-/-Trash" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                                                            <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" id="round" fill="#000000" fill-rule="nonzero"></path>
                                                                            <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" id="Shape" fill="#000000" opacity="0.3"></path>
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                        		            </th>
                        		        </tr>
                        		        <tr id="quantity_item_{{$item->id}}" style="display:none">
                        		            <form id="addInventoryItemQuantity_{{$item->id}}" action="{{route('admin.addInventoryItemQuantity',['id'=>$item->id])}}" method="post">
                    		                    @csrf
                            		            <th>-</th>
                            		            <th>-</th>
                            		            <th>New Quantity</th>
                            		            <th>
                            		                <input type="number"
                                                        class="form-control"
                                                        name="quantity_{{$item->id}}"
                                                        required
                                                        min="1"> 
                                                </th>
                                                <th>
                                                    <button type="submit" class="btn btn-success"
                                                    onclick="document.getElementById('addInventoryItemQuantity_{{$item->id}}').submit();">
                                                        {{__('product.Save')}}
                                                    </button>
                                                </th>
                                                <th>-</th>
                                                <th>-</th>
                                            </form>
                        		        </tr>
                    		        @empty
                    		        @endforelse
                    		    </tbody>
                    		</table>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="footer"></x-slot>
</x-master>





