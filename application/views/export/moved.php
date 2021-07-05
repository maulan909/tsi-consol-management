<title><?= $title . ' ' . date('H:m:s d-m-Y', time()); ?></title>

<body>
    <table cellspacing="0" border="1">
    <tr>
        <th>External Order No</th>
        <th>Total Picklist</th>
        <th>Kekurangan</th>
        <th>Lokasi Palet</th>
        <th>Dry/Fresh</th>
        <th>Frozen/Chiller</th>
    </tr>
    <?php foreach ($orders as $order) : ?>
        <?php $picklist = $this->package->getTotalPicklist($order); ?>
        <?php $koli = $this->package->getTotalKoli($order); ?>
        <tr>
            <td><?= $order; ?></td>
            <td><?= $picklist['total']; ?></td>
            <td><?php if (is_int($picklist['total'])) echo $picklist['total'] - $picklist['consol']; ?></td>
            <td><?= $this->package->getLocation($order); ?></td>
            <td><?= $koli['dry']; ?> Koli</td>
            <td><?= $koli['frozen']; ?> Koli</td>
        </tr>
    <?php endforeach; ?>
</table>
</body>