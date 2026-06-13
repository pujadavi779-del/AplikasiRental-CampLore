<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PembayaranExport
{
    protected Collection $pesanan;

    public function __construct(Collection $pesanan)
    {
        $this->pesanan = $pesanan;
    }

    public function download(): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $ws = $spreadsheet->getActiveSheet();
        $ws->setTitle('Laporan Pembayaran');

        // ── Palette ──────────────────────────────────────────
        $G_DARK  = '1A3D2B';
        $G_MED   = '22543D';
        $G_LIGHT = 'EBF5EE';
        $WHITE   = 'FFFFFF';
        $GRAY    = 'C8DDD1';

        $STATUS_STYLE = [
            'selesai'    => ['label' => 'Lunas',      'bg' => 'D1FAE5', 'fg' => '065F46'],
            'dikemas'    => ['label' => 'Proses',     'bg' => 'FEF3C7', 'fg' => '92400E'],
            'dibatalkan' => ['label' => 'Dibatalkan', 'bg' => 'FEE2E2', 'fg' => '991B1B'],
        ];

        // ── Helper closures ───────────────────────────────────
        $solidFill = fn($hex) => [
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $hex]],
        ];
        $fontStyle = fn($hex, $bold = false, $size = 10, $name = 'Calibri') => [
            'font' => ['color' => ['rgb' => $hex], 'bold' => $bold, 'size' => $size, 'name' => $name],
        ];
        $center = fn() => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]];
        $right  = fn() => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT,  'vertical' => Alignment::VERTICAL_CENTER]];
        $middle = fn() => ['alignment' => ['vertical'   => Alignment::VERTICAL_CENTER]];

        $thinBorder = fn($color = 'C8DDD1') => [
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => $color]],
            ],
        ];

        // ── Column widths ─────────────────────────────────────
        $ws->getColumnDimension('A')->setWidth(28);
        $ws->getColumnDimension('B')->setWidth(17);
        $ws->getColumnDimension('C')->setWidth(32);
        $ws->getColumnDimension('D')->setWidth(14);
        $ws->getColumnDimension('E')->setWidth(22);
        $ws->getColumnDimension('F')->setWidth(24);
        $ws->getColumnDimension('G')->setWidth(18);

        // ── Row 1: Brand header ───────────────────────────────
        $ws->getRowDimension(1)->setRowHeight(48);
        $ws->mergeCells('A1:G1');
        $ws->setCellValue('A1', '🏕  CAMPLORE  ·  Laporan Transaksi Pembayaran');
        $ws->getStyle('A1')->applyFromArray(array_merge(
            $solidFill($G_DARK),
            $fontStyle($WHITE, true, 16),
            $center()
        ));

        // ── Row 2: Spacer ─────────────────────────────────────
        $ws->getRowDimension(2)->setRowHeight(8);

        // ── Row 3–4: Meta ─────────────────────────────────────
        $ws->getRowDimension(3)->setRowHeight(20);
        $ws->getRowDimension(4)->setRowHeight(20);
        $ws->setCellValue('A3', 'Tanggal Ekspor');
        $ws->setCellValue('C3', now()->format('d F Y'));
        $ws->setCellValue('A4', 'Periode Data');
        $ws->setCellValue('C4', 's/d ' . now()->format('d F Y'));

        foreach (['A3','A4'] as $cell) {
            $ws->getStyle($cell)->applyFromArray(array_merge(
                $fontStyle($G_MED, true, 10),
                $middle()
            ));
        }
        foreach (['C3','C4'] as $cell) {
            $ws->getStyle($cell)->applyFromArray(array_merge(
                $fontStyle('374151', false, 10),
                $middle()
            ));
        }

        // ── Row 5: Spacer ─────────────────────────────────────
        $ws->getRowDimension(5)->setRowHeight(8);

        // ── Row 6: Column headers ─────────────────────────────
        $ws->getRowDimension(6)->setRowHeight(36);
        $headers = ['A6' => 'ID PESANAN', 'B6' => 'PELANGGAN', 'C6' => 'EMAIL',
                    'D6' => 'STATUS', 'E6' => 'TOTAL BAYAR (Rp)',
                    'F6' => 'TANGGAL TRANSAKSI', 'G6' => 'METODE BAYAR'];

        foreach ($headers as $cell => $label) {
            $ws->setCellValue($cell, $label);
            $ws->getStyle($cell)->applyFromArray(array_merge(
                $solidFill($G_MED),
                $fontStyle($WHITE, true, 10),
                $center(),
                ['borders' => [
                    'allBorders'  => ['borderStyle' => Border::BORDER_THIN,   'color' => ['rgb' => $G_DARK]],
                    'bottom'      => ['borderStyle' => Border::BORDER_MEDIUM,  'color' => ['rgb' => $G_MED]],
                ]]
            ));
        }

        // ── Data rows ─────────────────────────────────────────
        $row = 7;
        foreach ($this->pesanan as $i => $pesanan) {
            $ws->getRowDimension($row)->setRowHeight(22);
            $zebra = ($i % 2 === 0) ? $G_LIGHT : $WHITE;

            $allItems  = \App\Models\Pesanan::where('order_id', $pesanan->order_id)->get();
            $total     = $allItems->sum('total_harga')
                       + $allItems->first()->biaya_pengiriman

                       + $allItems->first()->biaya_layanan;

            $st = $STATUS_STYLE[$pesanan->status] ?? ['label' => ucfirst($pesanan->status), 'bg' => 'F3F4F6', 'fg' => '374151'];

            // A: ID Pesanan
            $ws->setCellValue("A{$row}", $pesanan->order_id);
            $ws->getStyle("A{$row}")->applyFromArray(array_merge(
                $solidFill($zebra),
                ['font' => ['name' => 'Courier New', 'bold' => true, 'size' => 9, 'color' => ['rgb' => $G_MED]]],
                $middle(),
                $thinBorder()
            ));

            // B: Pelanggan
            $ws->setCellValue("B{$row}", $pesanan->pelanggan->name ?? '-');
            $ws->getStyle("B{$row}")->applyFromArray(array_merge(
                $solidFill($zebra), $fontStyle('111827', false, 10), $middle(), $thinBorder()
            ));

            // C: Email
            $ws->setCellValue("C{$row}", $pesanan->pelanggan->email ?? '-');
            $ws->getStyle("C{$row}")->applyFromArray(array_merge(
                $solidFill($zebra), $fontStyle('6B7280', false, 9), $middle(), $thinBorder()
            ));

            // D: Status (colored badge)
            $ws->setCellValue("D{$row}", $st['label']);
            $ws->getStyle("D{$row}")->applyFromArray(array_merge(
                $solidFill($st['bg']),
                ['font' => ['bold' => true, 'size' => 9, 'color' => ['rgb' => $st['fg']], 'name' => 'Calibri']],
                $center(),
                $thinBorder()
            ));

            // E: Total Bayar
            $ws->setCellValue("E{$row}", $total);
            $ws->getStyle("E{$row}")->applyFromArray(array_merge(
                $solidFill($zebra),
                ['font' => ['bold' => true, 'size' => 10, 'color' => ['rgb' => $G_DARK], 'name' => 'Calibri']],
                $right(),
                $thinBorder()
            ));
            $ws->getStyle("E{$row}")->getNumberFormat()->setFormatCode('#,##0');

            // F: Tanggal
            $ws->setCellValue("F{$row}", $pesanan->created_at->format('d M Y  H:i'));
            $ws->getStyle("F{$row}")->applyFromArray(array_merge(
                $solidFill($zebra), $fontStyle('6B7280', false, 9), $center(), $thinBorder()
            ));

            // G: Metode
            $ws->setCellValue("G{$row}", 'QRIS / Transfer');
            $ws->getStyle("G{$row}")->applyFromArray(array_merge(
                $solidFill($zebra), $fontStyle('6B7280', false, 9), $center(), $thinBorder()
            ));

            $row++;
        }

        $lastData = $row - 1;

        // ── Total row ─────────────────────────────────────────
        $ws->getRowDimension($row)->setRowHeight(28);
        $ws->mergeCells("A{$row}:D{$row}");
        $ws->setCellValue("A{$row}", 'TOTAL KESELURUHAN');
        $ws->getStyle("A{$row}")->applyFromArray(array_merge(
            $solidFill($G_DARK), $fontStyle($WHITE, true, 11), $right(), $thinBorder($G_DARK)
        ));

        $ws->setCellValue("E{$row}", "=SUM(E7:E{$lastData})");
        $ws->getStyle("E{$row}")->applyFromArray(array_merge(
            $solidFill($G_DARK),
            ['font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => $WHITE], 'name' => 'Calibri']],
            $right(),
            $thinBorder($G_DARK)
        ));
        $ws->getStyle("E{$row}")->getNumberFormat()->setFormatCode('#,##0');

        foreach (['F', 'G'] as $col) {
            $ws->getStyle("{$col}{$row}")->applyFromArray(array_merge(
                $solidFill($G_DARK), $thinBorder($G_DARK)
            ));
        }

        $totalRow = $row;
        $row += 2;

        // ── Summary section ───────────────────────────────────
        $ws->getRowDimension($row)->setRowHeight(14);
        $ws->setCellValue("A{$row}", 'RINGKASAN');
        $ws->getStyle("A{$row}")->applyFromArray($fontStyle($G_MED, true, 9));

        $row++;
        $ws->getRowDimension($row)->setRowHeight(26);
        foreach (['A' => 'Kategori', 'B' => 'Jumlah Transaksi', 'C' => 'Total (Rp)'] as $col => $label) {
            $ws->setCellValue("{$col}{$row}", $label);
            $ws->getStyle("{$col}{$row}")->applyFromArray(array_merge(
                $solidFill($G_MED), $fontStyle($WHITE, true, 10), $center(), $thinBorder()
            ));
        }

        $sumRows = [
            ['Lunas',      'selesai',    'D1FAE5', '065F46'],
            ['Proses',     'dikemas',    'FEF3C7', '92400E'],
            ['Dibatalkan', 'dibatalkan', 'FEE2E2', '991B1B'],
        ];

        foreach ($sumRows as [$label, $status, $bg, $fg]) {
            $row++;
            $ws->getRowDimension($row)->setRowHeight(22);

            $ws->setCellValue("A{$row}", $label);
            $ws->getStyle("A{$row}")->applyFromArray(array_merge(
                $solidFill($bg),
                ['font' => ['bold' => true, 'size' => 10, 'color' => ['rgb' => $fg], 'name' => 'Calibri']],
                $center(), $thinBorder()
            ));

            $ws->setCellValue("B{$row}", "=COUNTIF(D7:D{$lastData},\"{$label}\")");
            $ws->getStyle("B{$row}")->applyFromArray(array_merge(
                $fontStyle('111827', false, 10), $center(), $thinBorder()
            ));

            $ws->setCellValue("C{$row}", "=SUMIF(D7:D{$lastData},\"{$label}\",E7:E{$lastData})");
            $ws->getStyle("C{$row}")->applyFromArray(array_merge(
                $fontStyle($G_DARK, true, 10), $right(), $thinBorder()
            ));
            $ws->getStyle("C{$row}")->getNumberFormat()->setFormatCode('#,##0');
        }

        // ── Freeze pane ───────────────────────────────────────
        $ws->freezePane('A7');

        // ── Print settings ────────────────────────────────────
        $ws->getPageSetup()->setFitToWidth(1);
        $ws->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $spreadsheet->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(6, 6);

        // ── Stream download ───────────────────────────────────
        $filename = 'Laporan_Pembayaran_' . now()->format('d-m-Y') . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}