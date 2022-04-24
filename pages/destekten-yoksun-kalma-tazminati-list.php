<?php
/*
Created By PhpStorm
User : Taha KOÇAK	
Date : 5/9/2021	
File : destekten-yoksun-kalma-tazminati-list.php	
*/
$workers = $db->from("workers")->select("id,namesurname")->all();

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5 mt-5">
                <div class="card-header">
                    <h5>trh 2010 progressive run listesi</h5>
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

                                    <a href="<?=$siteUrl?>dokum?id=<?=$worker['id']?>"><i class="far fa-eye"></i></a>
                                    <a href="<?=$siteUrl?>tazminat/destekten-yolsun-kalma/edit?id=<?=$worker['id']?>"><i class="far fa-edit"></i></a>
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
