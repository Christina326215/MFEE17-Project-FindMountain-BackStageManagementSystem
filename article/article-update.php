<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
    <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate action="articleUpdate.php">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">編輯文章</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th scope="row" class="col-1">文章名稱</th>
                            <td class="col-3">
                                <input id="updateName" type="text" class="form-control" name="name" required>
                                <input id="updateId" type="hidden" class="form-control" name="id"  >
                                <!-- <div class="valid-feedback">
                                        Looks good!
                                    </div> -->
                                <div class="invalid-feedback">
                                    請輸入文章名稱
                                </div>
                            </td>
                            <th class="col-1">狀態</th>
                            <td colspan="3" class="col-7">
                                <!-- name="status" 放在select上 -->
                                <select id="updateStatus" class="custom-select" name="status" required>
                                    <!-- <option selected value="">選擇狀態</option> -->
                                    <option value="0">未上架</option>
                                    <option value="1">已上架</option>
                                </select>
                                <div class="invalid-feedback">
                                    請選擇狀態
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">所在地</th>
                            <td>
                                <input id="updateCity" type="text" class="form-control" name="city" maxlength="15" maxlength="15" required>
                                <div class="invalid-feedback">
                                    請輸入所在地
                                </div>
                            </td>
                            <th>最適季節</th>
                            <td>
                                <div class="form-check-inline">
                                    <input  id="updateSeson_sp" name="season[]" class="form-check-input" type="checkbox" value="1" id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        春季
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <input id="updateSeson_su" name="season[]" class="form-check-input" type="checkbox" value="2" id="defaultCheck2">
                                    <label class="form-check-label" for="defaultCheck2">
                                        夏季
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <input id="updateSeson_au"  name="season[]" class="form-check-input" type="checkbox" value="3" id="defaultCheck3">
                                    <label class="form-check-label" for="defaultCheck3">
                                        秋季
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <input id="updateSeson_wi" name="season[]" class="form-check-input" type="checkbox" value="4" id="defaultCheck4">
                                    <label class="form-check-label" for="defaultCheck4">
                                        冬季
                                    </label>
                                </div>
                                <!-- <div class="season"> -->
                                <div class="season">
                                        
                                </div>
                                <!-- </div> -->


                            </td>
                            <th>所需時間</th>
                            <td>                                
                                <!-- <select id="updateTime_D" name="time_D">
                                    <?php for ($i = 0; $i <= 6; $i++) { ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php } ?>
                                </select>
                                天
                                <select id="updateTime_H" name="time_H" >
                                    <?php for ($i = 0; $i <= 23; $i++) { ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php } ?>
                                </select>
                                小時
                                <select id="updateTime_M" name="time_M" >
                                    <?php for ($i = 0; $i <= 59; $i++) { ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php } ?>
                                </select>
                                分鐘 -->
                                

                                <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="time_D">天</label>
                                            <select id="updateTime_D" name="time_D" class="form-control" required>
                                                <?php for ($i = 0; $i <= 6; $i++) { ?>
                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="time_H">小時</label>
                                            <select id="updateTime_H" name="time_H" class="form-control" required>
                                                <?php for ($i = 0; $i <= 23; $i++) { ?>
                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="time_M">分鐘</label>
                                            <select id="updateTime_M" name="time_M" class="form-control" required>
                                                <?php for ($i = 0; $i <= 59; $i++) { ?>
                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                    </div>
                                
                                
                                <div class="invalid-feedback">
                                    請輸入所需時間
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">最高海拔</th>
                            <td>
                                <input id="updateHeight" type="number" class="form-control" name="height" maxlength="7" step=0.1 required>公尺
                                <div class="invalid-feedback">
                                    請輸入最高海拔
                                </div>
                            </td>
                            <th>難易度</th>
                            <td>
                                <select id="updateLevel" class="custom-select" name="level" required>
                                    <option selected value="">選擇難易度</option>
                                    <option value="1">低</option>
                                    <option value="2">中</option>
                                    <option value="3">高</option>
                                </select>
                                <div class="invalid-feedback">
                                    請選擇難易度
                                </div>
                            </td>
                            <th>里程</th>
                            <td>
                                <input id="updateDistance" type="number" class="form-control" name="distance" maxlength="7" step=0.1 required>公里
                                <div class="invalid-feedback">
                                    請輸入里程
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">步道類型</th>
                            <td>
                                <select id="updateMountain_type" class="custom-select" name="mountain_type" required>
                                    <option selected value="">選擇步道類型</option>
                                    <option value="1">郊山步道</option>
                                    <option value="2">高山步道</option>
                                </select>
                                <div class="invalid-feedback">
                                    請選擇步道類型
                                </div>
                            </td>
                            <th>申請入山</th>
                            <td>
                                <select id="updateApply" class="custom-select" name="apply" required>
                                    <option selected value="">是否申請</option>
                                    <option value="1">否</option>
                                    <option value="2">是</option>
                                </select>
                                <div class="invalid-feedback">
                                    請選擇是否需申請入山
                                </div>
                            </td>
                            <th>高度落差</th>
                            <td>
                                <input id="updateGap" type="number" class="form-control" name="gap" maxlength="7" step=0.1 required>公尺
                                <div class="invalid-feedback">
                                    請輸入高度落差
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">路面狀況</th>
                            <td>
                                <input id="updateRoad_status" type="text" class="form-control" name="road_status" maxlength="50" required>
                                <div class="invalid-feedback">
                                    請輸入路面狀況
                                </div>
                            </td>
                            <th>交通方式</th>
                            <td colspan="3">
                                <textarea id="updateTraffic" type="text" class="form-control" name="traffic" style="height: 100px" maxlength="350" required></textarea>
                                <div class="invalid-feedback">
                                    請輸入交通方式
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">照片</th>
                            <td colspan="5">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01">上傳照片</span>
                                    </div>
                                    <div class="custom-file">
                                        <input id="updatePic" type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="pic" >
                                        <label class="custom-file-label" for="inputGroupFile01">選擇檔案</label>
                                    </div>
                                    <div class="figure uploadPic">
                                        <input id="updateOldpic" type="hidden" name="old_img" value="">
                                    </div>
                                    <div class="invalid-feedback">
                                        請選擇照片檔案
                                    </div>
                                </div>
                                <div class="imgwrap">
                                    <img id="updateshowPic" id="" src="" alt="">
                                </div>
                            </td>


                        </tr>
                        <tr>
                            <th scope="row">文章內容</th>
                            <td colspan="5">
                                <!-- <textarea id="updateContent" class="form-control" style="height: 150px" name="content" maxlength="3000" required></textarea> -->
                                <textarea id="updateContent" placeholder="請輸入不超過3000個字" class="form-control updateContent" style="height: 150px" name="content" maxlength="3000" required></textarea>
                                <span class="updateNum">0/3000</span>

                                <div class="invalid-feedback">
                                    請輸入文章內容
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary mr-auto " data-dismiss="modal">關閉</button>
                <!-- <input type="reset" name="button2" value="重新填寫" class="btn btn-light" data-bs-dismiss="modal"> -->
                <button name="button" class="btn btn-success header-btn" type="submit">更新</button>
            </div>
        </div>
    </form>
    
    
    </div>
</div>