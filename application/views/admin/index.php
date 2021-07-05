<div class="container-fluid">

    <!-- Page Heading -->
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <?= $this->session->flashdata('messages'); ?>
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mt-3">
                <div class="card-body">
                    <?= form_open_multipart('admin'); ?>
                    <div class="form-group">
                        <label for="csv">Choose CSV file</label>
                        <input type="file" class="form-control-file" id="csv" name="csv" accept=".csv" required>
                    </div>
                    <div class="form-group">
                        <a href="http://redash.tanihub.com/api/queries/1107/results.csv?api_key=YVwzYB0sCtTHHAgP3ZTTgfIJj8BYOCKcwRKv1w3M" class="btn btn-success"><i class="fas fa-download"></i> Download CSV</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>