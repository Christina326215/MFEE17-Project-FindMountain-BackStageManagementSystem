<!-- end-->
                    <!-- Modal delete warning-->
                    <div class="modal fade delete-modal-ml" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-ml" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">刪除文章</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    是否確認刪除資料？
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success header-btn detail" data-dismiss="modal">關閉</button>
                                    <form action="productDeletePost.php" method="POST">
                                        <input type="hidden" id="checkIDList" name="checkIDList" value="">
                                        <button id="deletePost" type="submit" class="btn btn-danger mx-1">刪除</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end-->