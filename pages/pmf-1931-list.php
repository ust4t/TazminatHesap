<?php
/*
Created By PhpStorm
User : Taha KOÇAK
Date : 8/12/2021
File : pmf-1931-list.php
*/
$workers = $db->from("pmf_workers")->select("id,namesurname")->all();

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5 mt-5">
                <div class="card-header">
                    <h5>pmf 1931 listesi</h5>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                        <tr>
                            <th>Ad Soyad</th>
                            <th>İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($workers as $worker): ?>
                            <tr>
                                <td><?php echo $worker['namesurname'] ?></td>
                                <td>

                                    <a href="<?=$siteUrl?>pmf?id=<?=$worker['id']?>"><i class="far fa-eye"></i></a>
                                    <a href="<?=$siteUrl?>tazminat/pmf-1931/edit?id=<?=$worker['id']?>"><i class="far fa-edit"></i></a>
                                    <a href="javascript:deleteTazminat('<?=$worker['id']?>')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
