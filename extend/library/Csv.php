<?php

namespace library;

/**
 * Cvs 导出工具
 *
 * 流输出操作，支持输出大文件
 * @author Anyon <zoujingli@qq.com>
 * @date 2016-05-12 09:50
 */
class Csv {

    /**
     * 输出对象
     * @var string
     */
    protected $output;

    /**
     * 输出行数
     * @var int
     */
    protected $_row_nums = 0;

    /**
     * 构造函数
     * @param string $downname 下载的文件名
     * @param string $filename 输出文件流名
     */
    public function __construct($downname = 'export.csv', $filename = 'php://output') {
        if ($filename === 'php://output') {
            header("Content-type:text/csv");
            header("Content-Disposition:attachment;filename=" . $downname);
            header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
            header('Expires:0');
            header('Pragma:public');
        }
        $this->output = fopen($filename, 'w');
    }

    /**
     * 增加数据列
     * @param array $data
     */
    public function add_list($data) {
        foreach ($data as $row) {
            is_array($row) && $this->add_row($row);
        }
    }

    /**
     * 增加一行记录
     * @param array $row
     * @return Csv
     */
    public function add_row($row) {
        $this->_row_nums++;
        if ($this->_row_nums % 1000 === 0) {
            ob_flush();
            flush();
        }
        fputcsv($this->output, $this->_convert_gbk($row));
        return $this;
    }

    /**
     * 整行数据转为GBK编码
     * @param string $row
     * @return string
     */
    protected function _convert_gbk($row) {
        foreach ($row as &$value) {
            $value = mb_convert_encoding($value, 'gbk', 'utf-8');
        }
        return $row;
    }

    /**
     * 关闭输出对象
     */
    public function close() {
        !empty($this->output) && fclose($this->output);
        $this->output = null;
    }

    /**
     * 魔术方法，销毁对象
     */
    public function __destruct() {
        $this->close();
    }

}
