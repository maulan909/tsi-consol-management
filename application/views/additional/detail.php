<div class="container-fluid">
    <h1 class="h3 mb-3 text-gray-800"><?= $title; ?> | <?= $id['ext_no']; ?></h1>
    <a href="<?= base_url('additional/log'); ?>" class="btn btn-primary mb-3">Kembali</a>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">External No</th>
                                <th scope="col">Action</th>
                                <th scope="col">Palet</th>
                                <th scope="col">Koli</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Date</th>
                                <th scope="col">User</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs->result_array() as $log) : ?>
                                <tr>
                                    <th scope="row"><?= $log['ext_no']; ?></th>
                                    <td><?= $log['action']; ?></td>
                                    <td><?= $log['palet']; ?></td>
                                    <td><?= $log['koli'] ?> Koli</td>
                                    <td>
                                        <?php if ($log['action'] != 'Move To Delivery' && $log['action'] != 'Move To Palet Consol') {
                                            if ($log['remarks'] == 1) {
                                                echo 'Frozen/Chiller';
                                            } else {
                                                echo 'Dry/Fresh';
                                            }
                                        }  ?>
                                    </td>
                                    <td><?= date('d-m-Y H:m:s', $log['time']); ?></td>
                                    <td><?= $log['user']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>