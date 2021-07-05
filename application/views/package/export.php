<title><?= $title . time(); ?></title>
<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment;filename=Ready To Move List " . time() . ".xls");
?>
<table border="1" cellspacing="0">
    <tr>
        <th>External Order No</th>
        <th>Total Picklist</th>
        <th>Kekurangan</th>
        <th>Lokasi Palet</th>
        <th>Dry/Fresh</th>
        <th>Frozen/Chiller</th>
    </tr>
    <?php
    foreach ($order as $ord) {
        $picklist = $this->package->getTotalPicklist($ord, 0);
        if ($picklist['consol'] == $picklist['total']) {
            $koli = $this->package->getTotalKoli($ord);
            $detail = $this->db->get_where('tb_consol', ['ca_no' => $ord])->row_array();
    ?>
            <tr>
                <td><?= $ord; ?></td>
                <td><?= $picklist['total']; ?> Picklist</td>
                <td><?= $picklist['kekurangan']; ?> Picklist</td>
                <td><?= $detail['palet_no']; ?></td>
                <td><?= $koli['dry']; ?> Koli</td>
                <td><?= $koli['frozen']; ?> Koli</td>
            </tr>
    <?php
        }
    }
    ?>
</table>