<?php
class Pagination
{
    public $total = 0;
    public $page = 1;
    public $limit = 20;
    public $num_links = 5;
    public $url = '';
    public $get = array();
    //public $text = '显示 {start} - {end} 条（共 {total} 条，{pages} 页)';
//    public $text = '{total}-{pages} 页';
    public $text = '共<b> {pages} </b>页';
//    public $text_first = '|&lt;';
//    public $text_last = '&gt;|';
//    public $text_next = '&gt;';
//    public $text_prev = '&lt;';

    public $text_first = '首页';
    public $text_last = '尾页';
    public $text_next = '下一页';
    public $text_prev = '上一页';

    public $style_links = '';
    public $style_results = '';

    public function render()
    {
        $total = $this->total;

        if ($this->page < 1) {
            $page = 1;
        } else {
            $page = $this->page;
        }

        if (intval($this->limit) <= 0) {
            $limit = 10;
        } else {
            $limit = $this->limit;
        }
        $num_links = $this->num_links;
        $num_pages = ceil($total / $limit);

        if($page > $num_pages){
            $page = $num_pages;
        }

        if ($page < 2) {
            $output = '<li class="mr10" title="上一页"><a class="first prev-page" val="'.($page - 1).'"  href="javascript:void(0)">' . $this->text_prev . '</a></li>';
        }else{
            $output = '<li class="mr10" title="上一页"><a val="'.($page - 1).'"   href="' . str_replace('{page}', $page - 1, urldecode($this->url)) . '">' . $this->text_prev . '</a></li>';
        }

        if ($num_pages > 1) {
            if ($num_pages <= $num_links) {
                $start = 1;
                $end = $num_pages;
            } else {
                $start = $page - floor($num_links / 2);
                $end = $page + floor($num_links / 2);

                if ($start < 1) {
                    $end += abs($start) + 1;
                    $start = 1;
                }

                if ($end > $num_pages) {
                    $start -= ($end - $num_pages);
                    $end = $num_pages;
                }
            }

            for ($i = $start; $i <= $end; $i++) {
                if ($page == $i) {
                    $output .= '<li class="selected mr10"><a rel="follow" class="selected" val="'.$i.'" href="javascript:void(0)" >' . $i . '</a></li> ';
                } else {
                    $output .= '<li class="mr10"><a rel="follow" val="'.$i.'"   href="' . str_replace('{page}', intval($i), urldecode($this->url)) . '" >' . $i . '</a></li> ';
                }
            }
        }

        if ($page == $num_pages) {
            $output .= '<li class="mr10" title="下一页"><a class="first" val="'.($page + 1).'"  href="javascript:void(0)">' . $this->text_next . '</a></li>';
        }else{
            $output .= '<li class="mr10" title="下一页"><a val="'.($page + 1).'"  href="' . str_replace('{page}', intval($page) + 1, urldecode($this->url)) . '">' . $this->text_next . '</a></li>';
        }

        $find = array(
            '{start}',
            '{end}',
            '{total}',
            '{pages}'
        );

        $replace = array(
            ($total) ? (($page - 1) * $limit) + 1 : 0,
            ((($page - 1) * $limit) > ($total - $limit)) ? $total : ((($page - 1) * $limit) + $limit),
            $total,
            $num_pages
        );
        if ($output) {

        } else {
            $output = '';
        }
        $output = '<div class="page m-page"><ul class="page-ul-init mr5 ' . $this->style_links . '">' . $output . '';
        $output.= '<li><a href="javascript:void(0)" class="num">'.str_replace($find, $replace, $this->text).'</a></li></ul>';
        $output.= '<div class="clear"></div></div>';
        return $output;
    }
}

?>