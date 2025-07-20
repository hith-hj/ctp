$('document').ready(function() {
    changeStatusOrder();
    demo();
});

function demo() {
    let searchParams = new URLSearchParams(window.location.search);
    let table = $('#kt_datatable');
    let locale = table.attr('data-locale') === '' ? "en" : table.attr('data-locale');
    let apiUrl = table.attr('data-url');
    let apiStatus = table.attr('data-status');
    let columnsName = {
        'ar' : {
            'code': 'كود',
            'customer': 'الزبون',
            'vendor': 'الزبون',
            'order_date' : 'تاريخ الطلب',
            'status' : 'الحالة',
            'Actions' : 'الاجراءات',
        },
        'en' : {
            'code': 'Code',
            'customer': 'Customer',
            'vendor': 'Vendor',
            'order_date' : 'Order Date',
            'status' : 'Status',
            'Actions' : 'Actions',
        },
    };

    let datatable = table.KTDatatable({
        // datasource definition
        data: {
            type: 'remote',
            source: {
                read: {
                    url: apiUrl ,
                    // sample custom headers
                    headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    map: function(raw) {
                        // sample data mapping
                        let dataSet = raw;
                        if (typeof raw.data !== 'undefined') {
                            dataSet = raw.data;
                        }
                        return dataSet;
                    },
                    params :{
                        query :{
                            status : searchParams.has('status') ? searchParams.get('status') : null,
                            from_date : searchParams.has('from_date') ? searchParams.get('from_date') : null,
                            to_date : searchParams.has('to_date') ? searchParams.get('to_date') : null
                        }
                    },
                },
            },
            pageSize: 10,
            serverPaging: true,
            serverFiltering: true,
            serverSorting: true,

        },
        // layout definition
        layout: {
            scroll: false,
            footer: false,
        },

        // column sorting
        sortable: true,

        pagination: true,

        // columns definition
        columns: [{
            field: 'code',
            title: columnsName[locale]['code'],
            width: 90,
            textAlign: 'center',
        }, {
            field: 'user_id',
            title: columnsName[locale]['customer'],
        }, {
            field: 'admin_id',
            title: columnsName[locale]['vendor'],
        }, {
            field: 'created_at',
            title: columnsName[locale]['order_date'],
            type: 'date',
            format: 'MM/BB/YYYY',
        }, {
            field: 'status',
            title: columnsName[locale]['status'],
            template: function(row) {

                let status = {
                    1: {
                        'title:en': 'Pending',
                        'title:ar': 'معلق',
                        'class': ' label-light-info'
                    },
                    2: {
                        'title:en': 'Ongoing',
                        'title:ar': 'جاري',
                        'class': ' label-light-danger'
                    },
                    3: {
                        'title:en': 'Cancelled',
                        'title:ar': 'ملغاة',
                        'class': ' label-light-primary'
                    },
                    4: {
                        'title:en': 'Delivered',
                        'title:ar': 'تم التسليم',
                        'class': ' label-light-success'
                    },
                    5: {
                        'title:en': 'Returned',
                        'title:ar': 'طلب اعادة',
                        'class': ' label-light-warning'
                    },
                    6: {
                        'title:en': 'Refunded',
                        'title:ar': 'معاد الدفع',
                        'class': ' label-light-primary'
                    },
                };
                if (apiStatus !== 'undefined' && apiStatus !== undefined) {
                    return status[apiStatus]['title:' + locale];
                }
                let options = ' ';

                for (const key in status) {
                    options += '<option value="' + key + '" ' + (row.status == key ? 'selected' : "") + '>' + status[key]['title:' + locale] + '</option>\n';
                }
                return ' <span class="text-dark-75 font-weight-bolder d-block font-size-lg">\n' +
                    '         <span class="label label-lg label-inline ' + status[row.status].class + ' mr-2">\n' +
                    '               <select class="btn btn-dropdown dropdown-toggle"\n' +
                    '                    id="statusOrder" name="statusOrder" data-id="'+ row.id +'"\n' +
                    '                    style="width: 100% !important; opacity: 1 !important;">\n'+
                                       options+
                    '               </select>\n' +
                    '         </span>\n' +
                    '  </span>';
            },
        },{
            field: 'Actions',
            title: columnsName[locale]['Actions'],
            sortable: false,
            width: 125,
            overflow: 'visible',
            autoHide: false,
            template: function(row) {
                let showAction =  '\
                        <div class="dropdown dropdown-inline">\
                            <a href="/admin/orders/' + row.id + '" class="btn btn-sm btn-clean btn-icon" title="Show">\
                                <span class="svg-icon svg-icon-md svg-icon-primary">\
                                    <span class="svg-icon"><!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->\
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                                <polygon points="0 0 24 0 24 24 0 24"/>\
                                                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000) " x="11" y="5" width="2" height="14" rx="1"/>\
                                                <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997) "/>\
                                            </g>\
                                        </svg><!--end::Svg Icon-->\
                                    </span>\
                                </span>\
                            </a>\
                        </div>\
                    ';
                if (apiStatus === 'undefined' || apiStatus === undefined || apiStatus == 3 || apiStatus == 4 || apiStatus == 6) {
                    return showAction;
                }else if(apiStatus == 1){
                    return '\
                        <div class="dropdown dropdown-inline hover:translate-x-full">\
                            <a data-id="'+row.id+'" data-action="approve"  class="btn btn-sm btn-clean btn-icon change-order-status" title="Approve">\
                            <i class="flaticon2-check-mark text-success text-hover-info"></i>\
                            </a>\
                            <a data-id="'+row.id+'" data-action="reject"  class="btn btn-sm btn-clean btn-icon change-order-status" title="Reject">\
                            <i class="flaticon2-cancel text-primary text-hover-info"></i>\
                            </a>\
                        </div>\
                        ' + showAction;
                }else if (apiStatus == 2){
                    return '\
                        <div class="dropdown dropdown-inline hover:translate-x-full">\
                            <a data-id="'+row.id+'" data-action="deliver"  class="btn btn-sm btn-clean btn-icon change-order-status" title="Delivered">\
                            <i class="flaticon2-delivery-package text-success text-hover-info"></i>\
                            </a>\
                        </div>\
                        ' + showAction;
                }else if (apiStatus === 5){
                    return '\
                        <div class="dropdown dropdown-inline hover:translate-x-full">\
                            <a data-id="'+row.id+'" data-action="refund"  class="btn btn-sm btn-clean btn-icon change-order-status" title="Delivered">\
                            <i class="flaticon2-reply text-primary text-hover-info"></i>\
                            </a>\
                        </div>\
                        ' + showAction;
                }
            },
        }
        ],
    });
    const url = new URL(window.location.href);

    $('#kt_datatable_search_status').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'status');
        url.searchParams.set('status', $(this).val().toLowerCase());
        window.history.replaceState(null, null, url);
    });

    $('#kt_datatable_search_from_date').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'from_date');
        url.searchParams.set('from_date', $(this).val().toLowerCase());
        window.history.replaceState(null, null, url);
    });

    $('#kt_datatable_search_to_date').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'to_date');
        url.searchParams.set('to_date', $(this).val().toLowerCase());
        window.history.replaceState(null, null, url);
    });

    table.on('datatable-on-layout-updated', function() {
        changeStatusOrder(table);
    });

    setInterval(function() {
        if($("#kt_datatable:hover").length === 0){
            datatable.reload()
        }
    }, 10000);
}

function changeStatusOrder(table) {
    $('.change-order-status').on('click', function(){
       let id = this.getAttribute('data-id');
       let action = this.getAttribute('data-action');
       confirmChangeStatus(id, action, 0, table);
    });

    $('select[name="statusOrder"]').on('change', function () {
        let id = this.getAttribute('data-id');
        confirmChangeStatus(id, 'change', this.value, table);
    });
}

function confirmChangeStatus(id, action = 'change', status= 0, table = null){

    if (action === 'approve'){
        status =  2 //Order::STATUS_ONGOING
    }else if (action === 'reject') {
        status =  3 //Order::STATUS_CANCELLED
    }else if (action === 'deliver') {
        status = 4 //Order::STATUS_DELIVERED
    }else if (action === 'refund') {
        status = 6 //Order::STATUS_REFUNDED
    }

    Swal.fire({
        title: "Confirm!",
        text: "Are you sure you want to "+ action +" this order?",
        icon: "warning",
        buttonsStyling: false,
        confirmButtonText: "<i class='la la-thumbs-o-up'></i> Yes "+ action + " it!",
        showCancelButton: true,
        cancelButtonText: "<i class='la la-thumbs-down'></i> No, thanks",
        customClass: {
            confirmButton: "btn btn-danger",
            cancelButton: "btn btn-default"
        }
    }).then(function (result) {
        if (result.value) {
            setOrderStatus(id, status, table)
        } else if (result.dismiss === "cancel") {
            Swal.fire(
                "Cancelled",
                "Your order is safe :)",
                "error"
            )
        }
    });
}

function setOrderStatus(id, status, table){
    $.ajax(
        {
            url: '/admin/orders/setOrderStatus/' + id,
            data: {
                status: status,
            },
            success: function(result){
                if (table != null){
                    table.reload();
                }else{
                    setInterval(function(){
                        window.location.reload();
                    }, 2000);
                }
                Swal.fire({
                    text: result,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "<i class='la la-thumbs-o-up'></i> OK!",
                    showCancelButton: false,
                    customClass: {
                        confirmButton: "btn btn-danger",
                    }
                });
            }
        });
}
