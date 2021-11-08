<div class="modal fade" id="checkModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">查看文章</h5>
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
                                <input id="checkName" type="text" class="form-control" name="name" readonly>
                            </td>
                            <th class="col-1">狀態</th>
                            <td colspan="3" class="col-7">
                                <select id="checkStatus" class="custom-select" name="status" disabled>
                                    <option value="0">未上架</option>
                                    <option value="1">已上架</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">所在地</th>
                            <td>
                                <input id="checkCity" type="text" class="form-control" name="city" readonly>
                            </td>
                            <th>最適季節</th>
                            <td id="checkSeason">
                                <!-- <div class="form-check-inline">
                                    <input id="updateSeson[]" name="season[]" class="form-check-input" type="checkbox" value="1" id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        春季
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <input id="updateSeson[]" name="season[]" class="form-check-input" type="checkbox" value="2" id="defaultCheck2">
                                    <label class="form-check-label" for="defaultCheck2">
                                        夏季
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <input id="updateSeson[]" name="season[]" class="form-check-input" type="checkbox" value="3" id="defaultCheck3">
                                    <label class="form-check-label" for="defaultCheck3">
                                        秋季
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <input id="updateSeson[]" name="season[]" class="form-check-input" type="checkbox" value="4" id="defaultCheck4">
                                    <label class="form-check-label" for="defaultCheck4">
                                        冬季
                                    </label>
                                </div> -->
                            </td>
                            <th>所需時間</th>
                            <td>
                                <!-- <input id="checkTime" type="text" class="form-control" name="time" readonly>分鐘 -->

                                <!-- <select id="checkTime_D" name="time_D" disabled>
                                    <?php for ($i = 0; $i <= 6; $i++) { ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php } ?>
                                </select>
                                天
                                <select id="checkTime_H" name="time_H" disabled>
                                    <?php for ($i = 0; $i <= 23; $i++) { ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php } ?>
                                </select>
                                小時
                                <select id="checkTime_M" name="time_M" disabled>
                                    <?php for ($i = 0; $i <= 59; $i++) { ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php } ?>
                                </select>
                                分鐘 -->




                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="time_D">天</label>
                                        <select id="checkTime_D" name="time_D" class="form-control" disabled>
                                            <?php for ($i = 0; $i <= 6; $i++) { ?>
                                                <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="time_H">小時</label>
                                        <select id="checkTime_H" name="time_H" class="form-control" disabled>
                                            <?php for ($i = 0; $i <= 23; $i++) { ?>
                                                <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="time_M">分鐘</label>
                                        <select id="checkTime_M" name="time_M" class="form-control" disabled>
                                            <?php for ($i = 0; $i <= 59; $i++) { ?>
                                                <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>



                            </td>
                        </tr>
                        <tr>
                            <th scope="row">最高海拔</th>
                            <td>
                                <input id="checkHeight" type="number" class="form-control" name="height" readonly>公尺
                            </td>
                            <th>難易度</th>
                            <td>
                                <select id="checkLevel" class="custom-select" name="level" disabled>
                                    <option value="1">低</option>
                                    <option value="2">中</option>
                                    <option value="3">高</option>
                                </select>
                            </td>
                            <th>里程</th>
                            <td>
                                <input id="checkDistance" type="number" class="form-control" name="distance" readonly>公里
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">步道類型</th>
                            <td>
                                <select id="checkMountain_type" class="custom-select" name="mountain_type" disabled>
                                    <option value="1">郊山步道</option>
                                    <option value="2">高山步道</option>
                                </select>
                            </td>
                            <th>申請入山</th>
                            <td>
                                <select id="checkApply" class="custom-select" name="apply" disabled>
                                    <option value="1">否</option>
                                    <option value="2">是</option>
                                </select>
                            </td>
                            <th>高度落差</th>
                            <td>
                                <input id="checkGap" type="number" class="form-control" name="gap" readonly>公尺
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">路面狀況</th>
                            <td>
                                <input id="checkRoad_status" type="text" class="form-control" name="road_status" readonly>
                            </td>
                            <th>交通方式</th>
                            <td colspan="3">
                                <textarea id="checkTraffic" type="text" class="form-control" name="traffic" style="height: 100px" readonly></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">照片</th>
                            <td colspan="5">
                                <div class="imgwrap">
                                    <img class="info-img img-thumbnail" id="checkPic" src="" alt="">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">文章內容</th>
                            <td colspan="5">
                                <textarea id="checkContent" class="form-control" style="height: 150px" name="content" readonly></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="modal-footer d-flex">
                    <button type="button" class="btn btn-outline-secondary ml-auto " data-dismiss="modal">關閉</button>
                </div>
            </div>
        </div>
    </div>
</div>