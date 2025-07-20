$('document').ready(function() {
    dataTable();
});

function dataTable() {
    let searchParams = new URLSearchParams(window.location.search);
    let table = $('#kt_datatable');
    let locale = table.attr('data-locale') === '' ? "en" : table.attr('data-locale');
    let apiUrl = table.attr('data-url');
    let columnsName = {
        'ar' : {
            'review': 'التقييم',
            'customer': 'الزبون',
            'review_date' : 'تاريخ الطلب',
            'review_content' : 'تاريخ الطلب',
            'Actions' : 'الاجراءات',
        },
        'en' : {
            'review': 'Review',
            'customer': 'Customer',
            'review_date' : 'Review Date',
            'review_content' : 'Review Content',
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
        columns: [ {
            field: 'user_id',
            title: columnsName[locale]['customer'],
        }, {
            field: 'review',
            title: columnsName[locale]['review'],
            width: 90,
            textAlign: 'center',
        },{
            field: 'content',
            title: columnsName[locale]['review_content'],
            sortable: false,
        }, {
            field: 'created_at',
            title: columnsName[locale]['review_date'],
            type: 'date',
            format: 'MM/BB/YYYY',
        }, {
            field: 'Actions',
            title: columnsName[locale]['Actions'],
            sortable: false,
            width: 125,
            overflow: 'visible',
            autoHide: false,
            template: function(row) {
                let showAction;
                return showAction = '\
                        <div class="dropdown dropdown-inline">\
                            <a href="/admin/reviews/' + row.id + '" class="btn btn-sm btn-clean btn-icon" title="Show">\
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
            },
        }
        ],
    });
    const url = new URL(window.location.href);

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

    setInterval(function() {
        if($("#kt_datatable:hover").length === 0){
            datatable.reload()
        }
    }, 10000);
}
