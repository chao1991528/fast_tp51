define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'mailreceive/index',
                    add_url: '',
                    edit_url: '',
                    del_url: '',
                    multi_url: 'mailreceive/multi',
                    table: 'mailreceive',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'subject', title: __('Subject'),operate: 'LIKE %...%'},
                        {field: 'from', title: __('From'),operate: 'LIKE %...%'},
                        {field: 'to', title: __('To'),operate: 'LIKE %...%'},
                        {field: 'status', title: __('Status'), visible:false, searchList: {"1":__('Status 1'),"-1":__('Status -1')}},
                        {field: 'status_text', title: __('Status'), operate:false},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate
                        ,buttons:[
                                {
                                    name: 'detail',
                                    title: "邮件内容",
                                    classname: 'btn btn-xs btn-primary btn-dialog',
                                    icon: 'fa fa-list',
                                    url: function (data) {
                                        return 'mailreceive/detail?id='+data.id;
                                    }
                                },
                            ]}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});