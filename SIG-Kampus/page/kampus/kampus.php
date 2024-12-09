<div class="row"> 
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Kampus
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <div>
                        <a href="?page=kampus&aksi=tambah" class="btn btn-success" style="margin-top: 8px;">
                            <i class="fa fa-plus"></i> Tambah Data
                        </a>
                    </div><br>
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NAMA</th>
                                <th>ALAMAT</th>
                                <th>VISI MISI</th>
                                <th>PRODI</th>
                                <th>FOTO</th>
                                <th>LATITUDE</th>
                                <th>LONGITUDE</th>
                                <th width="19%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $sql = $koneksi->query("SELECT * FROM tb_kampus");

                            while ($data = $sql->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($data['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($data['alamat']); ?></td>
                                    <td><?php echo htmlspecialchars($data['visi_misi']); ?></td>
                                    <td><?php echo htmlspecialchars($data['prodi']); ?></td>
                                    <td> <img src="images/<?php echo  $data['foto'];?>" width="75" height="50"> </td>
                                    <td><?php echo htmlspecialchars($data['latitude']); ?></td>
                                    <td><?php echo htmlspecialchars($data['longitude']); ?></td>
                                    <td>
                                        <a href="?page=kampus&aksi=ubah&id=<?php echo $data['id']; ?>" class="btn btn-warning">
                                            <i class="fa fa-edit"></i> Ubah
                                        </a>
                                        <a onclick="return confirm('Anda ingin menghapus?')" href="?page=kampus&aksi=hapus&id=<?php echo $data['id']; ?>" class="btn btn-danger">
                                            <i class="fa fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
