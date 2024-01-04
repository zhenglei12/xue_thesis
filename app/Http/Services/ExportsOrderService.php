<?php


namespace App\Http\Services;


use App\Http\Constants\BaseConstants;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportsOrderService implements FromCollection, WithHeadings, WithStyles
{
    use Exportable;

    private $data;

    public function __construct($result)
    {
        $this->setData($result);
    }

    public function headings(): array
    {
        return ["id", "客户类型", "客户名称", "标的金额", "合同比例", "订金金额", "订金截图", "尾款金额", "尾款截图", "回款金额", "增收截图", "财务审核", "客服备注", "所属客服", "法务", "售后金额", "状态", "客户等级", "售后人员", "创建时间"];
    }


    public function collection()
    {
        return collect($this->data);
    }

    public function styles(Worksheet $sheet)
    {
    }

    public function defaultStyle(Worksheet $sheet)
    {
        $sheet->getDefaultRowDimension()->setRowHeight(35);//设置默认行高
        $sheet->getDefaultColumnDimension()->setWidth(12);//设置默认的
        $sheet->getStyle('A1:H' . $this->row)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:H' . $this->row)->getAlignment()->setVertical('center');//设置第一行垂直居中
        $sheet->getStyle("A1:H" . $this->row)->getAlignment()->setHorizontal('center');//设置垂直居中
        $styles = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle('A1:h' . $this->row)->applyFromArray($styles);
    }


    private function setData($result)
    {
        $this->data = [];
        foreach ($result as $key => $v) {
            array_push($this->data, [
                $v['id'],
                BaseConstants::TASKTYPE[$v['name_type']],
                $v['name'],
                $v['amount'],
                $v['phone'],
                $v['received_amount'],
                $v['pay_img'],
                $v['end_received_amount'],
                $v['receipt_account'],
                $v['twice_received_amount'],
                $v['twice_img'],
                BaseConstants::FINANCE_STATUS[$v['finance_check']] ?? "",
                $v['remark'],
                $v['staff_name'],
                $v['edit_name'],
                $v['after_banlace'],
                BaseConstants::ORDERSTARTLIST[$v['status']],
                $v['wr_where'],
                $v['after_name'],
                $v['created_at'],
            ]);
        }

    }
}
