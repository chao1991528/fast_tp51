define(['jquery', 'bootstrap', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            // Table.api.init({
            //     extend: {
            //         index_url: 'user/user/index',
            //         add_url: 'user/user/add',
            //         edit_url: 'user/user/edit',
            //         del_url: 'user/user/del',
            //         multi_url: 'user/user/multi',
            //         table: 'user',
            //     }
            // });
            //
            // var table = $("#table");

            // 初始化表格
            // table.bootstrapTable({
            //     url: $.fn.bootstrapTable.defaults.extend.index_url,
            //     pk: 'id',
            //     sortName: 'user.id',
            //     showToggle: false,
            //     showColumns: false,
            //     showExport: false,
            //     searchFormVisible: true,
            //     search:false,
            //     columns: [
            //         [
            //             {checkbox: true},
            //             {field: 'id', title: __('Id'), sortable: true},
            //             {field: 'username', title: __('Username'), operate: 'LIKE'},
            //             {field: 'nickname', title: __('Nickname'), operate: 'LIKE'},
            //             {field: 'joinip', title: __('Joinip'), formatter: Table.api.formatter.search, opreate:false},
            //             {field: 'gender', title: __('Gender'), visible: false, searchList: {1: __('Male'), 0: __('Female')}},
            //             {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
            //         ]
            //     ]
            // });

            // 为表格绑定事件
            // Table.api.bindevent(table);
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