<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use app\common\model\Category as CategoryModel;
use fast\Tree;
use think\Collection;

/**
 * 分类管理
 *
 * @icon fa fa-list
 * @remark 用于统一管理网站的所有分类,分类可进行无限级分类
 */
class Category extends Backend
{

    /**
     * @var \app\common\model\Category
     */
    protected $model = null;
    protected $categorylist = [];
    protected $noNeedRight = ['selectpage'];

    public function initialize()
    {
        parent::initialize();
        request()->filter(['strip_tags']);
        $this->model = model('app\common\model\Category');

        $tree = Tree::instance();
        $tree->init(Collection::make($this->model->order('weigh desc,id desc')->select())->toArray(), 'pid');
        $this->categorylist = $tree->getTreeList($tree->getTreeArray(0), 'name');
        $categorydata = [0 => ['type' => 'all', 'name' => __('None')]];
        foreach ($this->categorylist as $k => $v)
        {
            $categorydata[$v['id']] = $v;
        }
        $this->view->assign("flagList", $this->model->getFlagList());
        $this->view->assign("typeList", CategoryModel::getTypeList());
        $this->view->assign("parentList", $categorydata);
    }

    /**
     * 查看
     */
    public function index()
    {
        if (request()->isAjax())
        {
            $search = request()->request("search");
            $type = request()->request("type");

            //构造父类select列表选项数据
            $list = [];

                foreach ($this->categorylist as $k => $v)
                {
                    if ($search) {
                        if ($v['type'] == $type && stripos($v['name'], $search) !== false || stripos($v['nickname'], $search) !== false)
                        {
                            if($type == "all" || $type == null) {
                                $list = $this->categorylist;
                            } else {
                                $list[] = $v;
                            }
                        }
                    } else {
                        if($type == "all" || $type == null) {
                            $list = $this->categorylist;
                        } else if ($v['type'] == $type){
                            $list[] = $v;
                        }

                    }

                }

            $total = count($list);
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * Selectpage搜索
     * 
     * @internal
     */
    public function selectpage()
    {
        return parent::selectpage();
    }

}
