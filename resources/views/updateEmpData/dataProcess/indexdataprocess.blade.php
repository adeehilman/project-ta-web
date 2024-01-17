@extends('layouts.app')
@section('title', 'Pengkinian Data Proses')

@section('content')
<style>
  .accordion-button:not(.collapsed) {
    background-color: #f8d7da;
    color: black;
  }
</style>

  <div class="wrappers">
    <div class="wrapper_content ">

        <div class="col-sm-12">
                    <a href="#" style="text-decoration: none">
                        <span class="text-black"><i class="bx bx-chevron-left"></i> Back to All Platform</span>
                    </a>
                    <span style="float: right;" >
                        <!-- <span class="text-black"> Terakhir Diperbarui : 1 Januari 2024</span> -->
                    </span>
                    <div class="row mt-2">
                      <div class="col-md-6">
                          <h4 class="mt-2 mb-2 fw-bold">Proses Pengkinian Data</h4>
                          <div class="downtime-status">
                              <span id="forkliftOpen">
                                  <label class="status-circle" style="width: 15px; height: 15px; border-radius: 50%; margin-left: 10px; display: inline-block; background-color: #3797D7; color: white; vertical-align: middle;"></label>
                                  <span style="display: inline-block; vertical-align: middle;"> Data Di Perbarui</span>
                              </span>
                              <span id="forkliftProg">
                                  <label class="status-circle" style="width: 15px; height: 15px; border-radius: 50%; margin-left: 10px; display: inline-block; background-color: #1DB74E; color: white; vertical-align: middle;"></label>
                                  <span style="display: inline-block; vertical-align: middle;"> Diterima</span>
                              </span>
                              <span id="forkliftClosed">
                                  <label class="status-circle" style="width: 15px; height: 15px; border-radius: 50%; margin-left: 10px; display: inline-block; background-color: #D74D58; color: white; vertical-align: middle;"></label>
                                  <span style="display: inline-block; vertical-align: middle;"> Ditolak</span>
                              </span>
                          </div>
                      </div>

                      <div class="col-md-6 d-flex justify-content-end">
                          <!-- <button style="font-size: 16px; height: 45px;" type="button" class="btn btn-outline-secondary rounded-3 me-2 btnHelp">
                              <i class='bx bx-help-circle p-1' style='font-size: 25px; margin-bottom: -8px;'></i>
                              <span style="vertical-align: middle; position: relative; top: -8px;">Bantuan</span>
                          </button> -->

                          {{-- filter List Department--}}
                          <select class="form-select rounded-3" id="filterDepartment" style="width: 250px; height: 45px;">
                              <option value="" selected>Semua Department</option>
                              @foreach ($statusDept as $statusDept)
                                  <option value="{{ $statusDept->dept_code }}">{{ $statusDept->dept_name }}</option>
                              @endforeach
                          </select>
                      </div>
                    </div>

            </div>

        
           <!-- modal close -->
           <div class="modal fade" data-bs-backdrop="static" id="modalCloseTicket" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalAddTitle">Detail Informasi</h1>
                            <button type="button" id="btnClosed" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <form id="formClose">
                            <div class="modal-body" style="font-size: 15px;">
                            <div>
                                <div class="d-sm-flex gap-3">
                                    <table class="ms-2" style="font-size: 15px; line-height: 2;">
                                        <tr>
                                            <td style="width: 200px; color: gray;">Kategori</td>
                                            <td style="color: black;" id="detailkategori"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:  200px; color: gray;">Karyawan</td>
                                            <td style="color: black;" id="detailKaryawan"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="accordion mt-4" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                <span style="font-size: 14px;">Perbandingan Data Sebelumnya dan Data Sekarang</span>
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="max-height: 400px;">
                                        <div class="accordion-body">
                                            <div class="table-responsive">
                                                <table id="tablePersonalList" class="table table-responsive table-hover" style="font-size: 13px;">
                                                    <thead>
                                                        <tr style="color: #CD202E; height: 10px;" class="table-danger ">
                                                            <th class="p-2" scope="col">Kategori</th>
                                                            <th class="p-2" scope="col">Tipe Data</th>
                                                            <th class="p-2" scope="col">Data Lama</th>
                                                            <th class="p-2" scope="col">Data Baru</th>
                                                            <th class="p-2" scope="col">Dokumen</th>                                                        
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="row mb-3 mt-3">
                                    <div class="col-sm-12">
                                        <label>Alasan</label>
                                        <div>
                                            <textarea class="mt-2" id="reasoncloseticket" name="reasoncloseticket" style="border-radius: 10px; height: 100px; width: 770px; border-color: #ccc; padding: 20px"></textarea>
                                        </div>
                                        <div id="err-reasoncloseticket" class="text-danger d-none">
                                            Kolom Alasan Tidak Boleh Kosong
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" id="btnReject"
                                style="text-decoration: none;">Tolak</button>
                            <button type="submit" id="btnApprove" class="btn btn-primary">Terima</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end modal close -->

            <!-- modal Filter-->
            <div class="modal fade" data-bs-backdrop="static" id="modalFilter" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalFilterTitle">Filter Downtime Ticket</h1>
                            <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 16px;">
                            <form id="formFilterTicket">
                                <div class="row mb-3 mt-3">
                                    <div class="col-sm-12">
                                        <label for="selectDepartment" class="form-label">Department</label>    
                                        <select class="form-select" id="selectDepartment"style="width: 100%" multiple>
                                            <option value="xiaomi">Xiaomi</option>
                                            <option value="smt">SMT</option>
                                            <option value="moulding">Moulding</option>
                                            <option value="coinbattery">Coin Battery</option>
                                            <option value="lithiumbattery">Lithium Battery</option>
                                            <option value="toa">TOA</option>
                                            <option value="digi">DIGI</option>
                                        </select>
                                        <div id="err-selectDepartmentFilter" class="text-danger d-none">
                                            Please select a valid Department.
                                        </div>

                                    </div>
                                </div>
                                <div class="row mb-3 mt-3">
                                    <div class="col-sm-12">
                                        <label for="selectProductionline" class="form-label">Production Line</label>    
                                        <select class="form-select" id="selectProductionline"style="width: 100%" multiple>
                                            <option value="xiaomi">Xiaomi</option>
                                            <option value="smt">SMT</option>
                                            <option value="moulding">Moulding</option>
                                            <option value="coinbattery">Coin Battery</option>
                                            <option value="lithiumbattery">Lithium Battery</option>
                                            <option value="toa">TOA</option>
                                            <option value="digi">DIGI</option>
                                        </select>
                                        <div id="err-selectProductionline" class="text-danger d-none">
                                            Please select a valid Production Line.
                                        </div>

                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" id="btnReset" data-bs-dismiss="modal"
                                style="text-decoration: none;">Reset</button>
                            <button type="button" id="btnFilterData" class="btn btn-primary">Show Results</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end modal Filter-->

            <!-- modal Open Maintenance -->
            <div class="modal fade" data-bs-backdrop="static" id="modalOpenMaintenance" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered" style="max-width: 1000px;">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h1 class="modal-title fs-5 fw-bold">Open Maintenance</h1>
                          <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="modal"
                              aria-label="Close"></button>
                      </div>
                      <div class="modal-body" style="font-size: 15px;">
                          <form id="formOpenMaintenance">
                              <div class="row mb-2">
                                  <div class="col-sm-12">
                                      <label class="form-label">Vehicle No</label>
                                    <div class="input-group">
                                        <input type="text" placeholder="Insert Vehicle No" id="checkVehicleNo" name="checkVehicleNo" class="form-control mb-1 rounded">
                                        <div class="input-group-append ms-2">
                                            <button style="font-size: 14px; width: 150px; height: 38px;" type="button" class="btn btn-outline-danger rounded-3 btnChecking">
                                                Checking
                                            </button>
                                        </div>
                                    </div>
                                    <div id="err-checkVehicleNo" class="text-danger d-none">
                                        Please Vehicle No field Required.
                                    </div>

                                  </div>
                              </div>
                              <div class="row mt-2">
                                      <div>
                                        <table class="mt-2" style="font-size: 14px; line-height: 2;">
                                          <!-- Info Machine -->
                                          <tr>
                                              <td style="width: 200px; font-weight: bold;">Information Vehicle</td>
                                          </tr>
                                          <tr>
                                              <td style="width: 200px; color: gray;">Plant</td>
                                              <td style="color: black;">-</td>
                                          </tr>
                                          <tr>
                                              <td style="width:  200px; color: gray;">Planner Group</td>
                                              <td style="color: black;">-</td>
                                          </tr>
                                          <tr>
                                              <td style="width: 200px; color: gray;">Vehicle Name</td>
                                              <td style="color: black;">-</td>
                                          </tr>
                                          <tr>
                                              <td style="width:  200px; color: gray;">Vehicle No</td>
                                              <td style="color: black;">-</td>
                                          </tr>
                                        </table>
                                      </div>
                              </div>
                              <div class="row">
                                  <div class="col-sm-4 mt-3">
                                      <label for="selectActivityOpen" class="form-label" style="font-size:15px;">Maintenance Activity</label>    
                                      <select class="form-select" id="selectActivityOpen" style="width: 98%">
                                          <option value="" disabled selected>Select Maintenance Activity</option>
                                          <option value="repair">REPAIR</option>
                                          <option value="replacement">REPLACEMENT</option>
                                          <option value="rewinding">REWINDING</option>
                                          <option value="instalation">INSTALATION</option>
                                      </select>
                                      <div id="err-selectActivityOpen" class="text-danger d-none mt-2">
                                          Maintenance Activity field is required.
                                      </div>
                                  </div>

                                  <div class="col-sm-4 mt-3">
                                    <label>Material Type</label>
                                    <div class="mt-3 ms-2" id="priorityOpen">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="priorityRadioOpen" id="lowradio" value="option1">
                                            <label class="form-check-label mt-1" for="lowradio">Low</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="priorityRadioOpen" id="normalRadio" value="option2">
                                            <label class="form-check-label mt-1" for="normalRadio">Normal</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="priorityRadioOpen" id="urgentRadio" value="option3">
                                            <label class="form-check-label mt-1" for="urgentRadio">Urgent</label>
                                        </div>
                                    </div>
                                    <div id="err-priorityOpen" class="text-danger d-none mt-2 ms-2">
                                        Priority field is required.
                                    </div>
                                  </div>

                                  <div class="col-sm-4 mt-3">
                                      <label for="selectDuedate" class="form-label" style="font-size:15px;">Maintenance Due Date (Optional)</label>    
                                          <input type="date" class="form-control" id="duedate" name="duedate">
                                  </div>
                                  
                                  <div class="col-sm-12 mt-3">
                                      <label>Problem</label>
                                      <div>
                                          <textarea class="mt-2" id="actionproblem" placeholder="Insert Problem" name="actionproblem" style="border-radius: 10px; height: 150px; width: 960px; border-color: #ccc; padding: 20px"></textarea>
                                      </div>
                                      <div id="err-actionproblem" class="text-danger d-none">
                                          Problem field is required.
                                      </div>
                                  </div>

                              </div>
                          </form>

                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-link" data-bs-dismiss="modal"
                              style="text-decoration: none;">Cancel</button>
                          <button type="button" id="btnAddOpenMaintenance" class="btn btn-primary">Open Maintenance</button>
                      </div>

                  </div>
              </div>
          </div>
          <!-- end modal Open Maintenance -->
          

          <div class="row" style="margin-top: 20px;">

            <div class="col" style="min-width:330px;">
              <div class="card ps-2 pe-2 vh-100 shadow">
                <div class="d-flex ps-2 gap-2">
                  <div class="coloum-title fw-bold">Pengkinian</div>
                  <span class="badge mb-auto mt-auto bg-danger total-items-label todo-label" style="float: right;" id="openlist_count"></span>
                </div>

                <!-- CARD -->
                <div class="col" style=" overflow-y: auto;" id="openlist">
                  <!-- <li data-id="1" class="card shadow-sm mb-3 total detailById">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="row">
                          <div class="col-sm-3">
                            <p class="openlist border-0 rounded" style="font-size: 7px;">&nbsp;&nbsp;&nbsp;</p>
                          </div>
                        </div>                       
                        <div class="col card-detail"> 
                          <div class="d-flex justify-content-between">
                            <div class="cardtitle mt-2" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 450px;">Nama, No. KK, Agama, Status Pernikahan, Riwayat Pendidikan, Kontak, Domisil</div>
                              <div class="text-end">
                                <div class="cardlabel">26 December 2023, 08.00</div>  
                              </div>
                            </div>
                            <div class="d-flex justify-content-between">
                              <div class="mt-1">
                                <div class="cardlabel">Farhan Abdurrahman (123456)</div>
                                <div class="cardlabel">DOT, GA22</div>
                              </div>
                              <div class="text-end mt-3">
                                <div class="cardlabel">Duration:</div>
                                <div class="cardtitle">13 Hours</div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                  </li>
                  <li data-id="1" class="card shadow-sm mb-3 total detailById">
                    <div class="card-body">
                      <div class="row align-items-center">
                      <div class="row">
                          <div class="col-sm-3">
                            <p class="openlist border-0 rounded" style="font-size: 7px;">&nbsp;&nbsp;&nbsp;</p>
                          </div>
                        </div> 
                        <div class="col">                            
                          <div class="d-flex justify-content-between">
                            <div class="cardtitle mt-2" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 450px;">Nama</div>
                              <div class="text-end">
                                <div class="cardlabel">26 December 2023, 10.00</div>  
                              </div>
                            </div>
                            <div class="d-flex justify-content-between">
                              <div class="mt-1">
                                <div class="cardlabel">Muhammad Iffaturrahman (1234567)</div>
                                <div class="cardlabel">MIS, GA26</div>
                              </div>
                              <div class="text-end mt-3">
                                <div class="cardlabel">Duration:</div>
                                <div class="cardtitle">11 Hours</div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                  </li>
                  <li data-id="1" class="card shadow-sm mb-3 total detailById">
                    <div class="card-body">
                      <div class="row align-items-center">
                          <div class="row">
                            <div class="col-sm-3">
                              <p class="openlist border-0 rounded" style="font-size: 7px;">&nbsp;&nbsp;&nbsp;</p>
                            </div>
                          </div> 
                          <div class="col">                            
                          <div class="d-flex justify-content-between">
                              <div class="cardtitle mt-2" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 450px;">No.KK</div>
                                <div class="text-end">
                                  <div class="cardlabel">26 December 2023, 14.00</div>  
                                </div>
                              </div>
                                <div class="d-flex justify-content-between">
                                  <div class="mt-1">
                                    <div class="cardlabel">Yuninda Faranika (123458)</div>
                                    <div class="cardlabel">Manager, DR11</div>
                                  </div>
                              <div class="text-end mt-3">
                                <div class="cardlabel">Duration:</div>
                                <div class="cardtitle">7 Hour</div>
                              </div>
                          </div>
                          </div>
                        </div>
                    </div>
                  </li> -->
                  
                </div>
              </div>
            </div>

            <div class="col" style="min-width:330px;">
              <div class="card ps-2 pe-2 vh-100 shadow" >
                <div class="d-flex ps-2 gap-2">
                  <div class="coloum-title fw-bold">Selesai</div>
                  <span class="badge mb-auto mt-auto bg-danger total-items-label todo-label" style="float: right;" id="closed_count"></span>
                </div>

                <!-- CARD -->
                <div class="col" style="overflow-y: auto;" id="closed">
                  <!-- <li data-id="2" class=" card shadow-sm mb-3 total detailById2">
                    <div class="card-body">
                      <div class="row align-items-center">
                      <div class="row">
                          <div class="col-sm-3">
                            <p class="approved border-0 rounded" style="font-size: 7px;">&nbsp;&nbsp;&nbsp;</p>
                          </div>
                        </div> 
                        <div class="col">                            
                          <div class="d-flex justify-content-between">
                            <div class="cardtitle mt-2" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 450px;">Status Pernikahan</div>
                              <div class="text-end">
                                <div class="cardlabel">26 December 2023, 16.00</div>  
                              </div>
                            </div>
                            <div class="d-flex justify-content-between">
                              <div class="mt-1">
                                <div class="cardlabel">Achmad Budi (123459)</div>
                                <div class="cardlabel">SMT, SM11</div>
                              </div>
                              <div class="text-end mt-3">
                                <div class="cardlabel">Duration:</div>
                                <div class="cardtitle">5 Hours</div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                  </li>
                  <li data-id="2" class="card shadow-sm mb-3 total detailById2">
                    <div class="card-body">
                      <div class="row align-items-center">
                      <div class="row">
                          <div class="col-sm-3">
                            <p class="approved border-0 rounded" style="font-size: 7px;">&nbsp;&nbsp;&nbsp;</p>
                          </div>
                        </div> 
                        <div class="col">                            
                          <div class="d-flex justify-content-between">
                            <div class="cardtitle mt-2" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 450px;">Kontak</div>
                              <div class="text-end">
                                <div class="cardlabel">26 December 2023, 14.00</div>  
                              </div>
                            </div>
                            <div class="d-flex justify-content-between">
                              <div class="mt-1">
                                <div class="cardlabel">Febby Fakhrian (123457)</div>
                                <div class="cardlabel">Xiaomi, MI11</div>
                              </div>
                              <div class="text-end mt-3">
                                <div class="cardlabel">Duration:</div>
                                <div class="cardtitle">7 Hours</div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                  </li>
                  <li data-id="2"class="card shadow-sm mb-3 total detailById2">
                    <div class="card-body">
                      <div class="row align-items-center">
                      <div class="row">
                          <div class="col-sm-3">
                            <p class="approved border-0 rounded" style="font-size: 7px;">&nbsp;&nbsp;&nbsp;</p>
                          </div>
                        </div> 
                        <div class="col">                            
                          <div class="d-flex justify-content-between">
                            <div class="cardtitle mt-2" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 450px;">Domisili</div>
                              <div class="text-end">
                                <div class="cardlabel">26 December 2023, 12.00</div>  
                              </div>
                            </div>
                            <div class="d-flex justify-content-between">
                              <div class="mt-1">
                                <div class="cardlabel">Renata Angelina (123458)</div>
                                <div class="cardlabel">Purchasing, GA24</div>
                              </div>
                              <div class="text-end mt-3">
                                <div class="cardlabel">Duration:</div>
                                <div class="cardtitle">9 Hours</div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                  </li>
                  <li data-id="3" class="card shadow-sm mb-3 total detailById2">
                    <div class="card-body">
                      <div class="row align-items-center">
                      <div class="row">
                          <div class="col-sm-3">
                            <p class="reject border-0 rounded" style="font-size: 7px;">&nbsp;&nbsp;&nbsp;</p>
                          </div>
                        </div> 
                        <div class="col">                            
                          <div class="d-flex justify-content-between">
                            <div class="cardtitle mt-2" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 450px;">Agama</div>
                              <div class="text-end">
                                <div class="cardlabel">26 December 2023, 08.00</div>  
                              </div>
                            </div>
                            <div class="d-flex justify-content-between">
                              <div class="mt-1">
                                <div class="cardlabel">Devi Puspita Pribadi (123460)</div>
                                <div class="cardlabel">Shipping, GA14</div>
                              </div>
                              <div class="text-end mt-3">
                                <div class="cardlabel">Duration:</div>
                                <div class="cardtitle">13 Hours</div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                  </li>
                  <li data-id="3" class="card shadow-sm mb-3 total detailById2">
                    <div class="card-body">
                      <div class="row align-items-center">
                      <div class="row">
                          <div class="col-sm-3">
                            <p class="reject border-0 rounded" style="font-size: 7px;">&nbsp;&nbsp;&nbsp;</p>
                          </div>
                        </div> 
                        <div class="col">                            
                          <div class="d-flex justify-content-between">
                            <div class="cardtitle mt-2" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 450px;">Riwayat Pendidikan</div>
                              <div class="text-end">
                                <div class="cardlabel">26 December 2023, 08.00</div>  
                              </div>
                            </div>
                            <div class="d-flex justify-content-between">
                              <div class="mt-1">
                                <div class="cardlabel">Ilham (123461)</div>
                                <div class="cardlabel">Pegatron, PG18</div>
                              </div>
                              <div class="text-end mt-3">
                                <div class="cardlabel">Duration:</div>
                                <div class="cardtitle">1 Day</div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                  </li> -->


                </div>
              </div>
            </div>

            

        </div>

      </div>
    </div>

    </div>

  </div>
@endsection

@section('script')
@include('updateEmpData.dataProcess.modalProcess_JS')

<script>
   // UNTUK LIST DATA OPEN PENGKINIAN
   $(document).ready(function () {

      $('#filterDepartment').change(function () {

      var selectedDept = $(this).val();

      loadOpenComplaintList(selectedDept);
      });

      function updateOpenComplaintCount() {
        var cardCount = $("#openlist .card").length;
        $("#openlist_count").text(cardCount);
      }

      function loadOpenComplaintList(selectedDept) {
        $.ajax({
            type: "GET",
            url: "{{ route('getListPengkinian') }}",
            dataType: "HTML",
            data: { selectedDept: selectedDept },
            success: function (response) {
                $("#openlist").html(response);
                updateOpenComplaintCount();
            },
            error: function (error) {
                console.error("Error fetching data:", error);
            }
        });
      }

      loadOpenComplaintList();

      function reloadOpenComplaintList() {
      loadOpenComplaintList();
      }

      $(document).on('click', '.btnReloadOpenList', function(e){
      reloadOpenComplaintList();
      
      setTimeout(function () {
            var cardCount = $("#openlist .card").length;
            $("#openlist_count").text(cardCount);
        }, 500); 
      });
    });

    // UNTUK LIST DATA SELESAI
    $(document).ready(function () {

      $('#filterDepartment').change(function () {

      var selectedDept = $(this).val();

      loadClosePengkinianList(selectedDept);
      });

    function updateClosePengkinianList() {
      var cardCount = $("#closed .card").length;
      $("#closed_count").text(cardCount);
    }

    function loadClosePengkinianList(selectedDept) {
      $.ajax({
          type: "GET",
          url: "{{ route('getListClosed') }}",
          dataType: "HTML",
          data: { selectedDept: selectedDept },
          success: function (response) {
              $("#closed").html(response);
              updateClosePengkinianList();
          },
          error: function (error) {
              console.error("Error fetching data:", error);
          }
      });
    }

      loadClosePengkinianList();

      function reloadClosePengkinianList() {
      loadClosePengkinianList();
      }

      $(document).on('click', '.btnReloadOpenList', function(e){
      reloadClosePengkinianList();

      setTimeout(function () {
            var cardCount = $("#closed .card").length;
            $("#closed_count").text(cardCount);
        }, 500); 
      });
    });
</script>
<script>
   $(document).ready(function () {
    // Inisialisasi sortable untuk kedua daftar
    $("#openlist").sortable({
        connectWith: "#closed",
        items: ".card",
        receive: function (event, ui) {

          var sourceListId = ui.sender.attr("id");
          
            // Periksa apakah card dipindahkan dari "Open" ke "Closed"
                updateTotalItemsLabel("#openlist");
                updateTotalItemsLabel("#closed");

        },

        remove: function (event, ui) {
            // Mengurangi jumlah kartu dari "Open/Reopen" saat dipindahkan ke "Maintenance in Progress"
            updateTotalItemsLabel("#openlist");
        },
    });


    $("#closed").sortable({
        connectWith: "#closed",
        items: ".card",
        receive: function (event, ui) {

            // asal tiket
            var sourceListId = ui.sender.attr("id");

            updateTotalItemsLabel("#closed");
            
            // Hitung jumlah kartu di "Today List" dan "To-Do List"
            updateTotalTodayAndToDoLabels();

            ui.item.find(".maintenanceinprogress").removeClass("maintenanceinprogress");
            ui.item.find(".border-0.rounded").addClass("closed");


            var modalID = ui.item.data('id');

            $.ajax({
                type: 'GET',
                url: '{{ route('getModalPengkinian') }}',
                data: {
                    modalID: modalID,
                },
                success: function (response) {
                  console.log(response);
                   const dataModalId = response.dataModalId;
                   const dataModaldeptId = response.dataModaldeptId;
                   const dataListTable = response.dataListTable;

                    $('#detailkategori').text(dataModalId.kategori);
                    $('#detailKaryawan').text(dataModalId.nama + ' ' +'('+ dataModalId.badgeid +')'+'  '+ ',' +'  '+ dataModaldeptId.line_code + ' ' + '  -  '+ dataModaldeptId.position_name);
                    
                    if ($.fn.DataTable.isDataTable('#tablePersonalList')) {
                          // Destroy DataTable before reinitializing
                          $('#tablePersonalList').DataTable().destroy();
                      }

                      // Display data in the table
                      const table = $('#tablePersonalList').DataTable({
                          data: dataListTable,
                          columns: [
                              { data: 'Kategori', className: 'p-2' },
                              { data: 'Detail', className: 'p-2' },
                              { data: 'fullname', className: 'p-2' },
                              { data: 'newdata', className: 'p-2' },
                              { data: 'dok_nama', className: 'p-2' }
                          ],
                          searching: false,
                          lengthChange: false,
                          "bSort": true,
                          "aaSorting": [],
                          pageLength: 5,
                          responsive: false,
                          autoWidth: false,
                          language: { search: "" }
                      });

                    // Tampilkan modal setelah data diisi
                    $('#modalCloseTicket').modal('show'); 
                  },
                error: function (error) {
                    console.error('Error getting modal maintenance data:', error);
                }
            });

            $('#btnClosed').click(function(e){
              var movedCard = ui.item;
              movedCard.prependTo(`#${sourceListId}`);
          
              if(sourceListId == "openlist"){
                ui.item.find(".closed").removeClass("closed");
                ui.item.find(".border-0.rounded").addClass("openlist");
              }
              $('#modalCloseTicket').modal('hide');

              updateTotalItemsLabel("#closed");
              updateTotalItemsLabel("#openlist");

              $('#err-reasoncloseticket').addClass('d-none');
              $('#reasoncloseticket').val('')

              $("#collapseOne").collapse('hide');

            })

            $('#btnReject').click(function(e) {

                const reasonReject = $('#reasoncloseticket').val();

                if (reasonReject == '' || reasonReject == null) {
                    $('#err-reasoncloseticket').removeClass('d-none');
                } else {
                    $('#err-reasoncloseticket').addClass('d-none');

                    Swal.fire({
                        title: "Apakah kamu ingin menolak pengajuan ini ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya', 
                        cancelButtonText: 'Tidak',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {

                          $.ajaxSetup({
                            headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                          });

                          $.ajax({
                            type: 'POST',
                            url: '{{ route('addReject') }}',
                            data: {
                                modalID,reasonReject
                            },
                            success: function (response) {
                                  
                              ui.item.find(".closed").removeClass("closed");
                              ui.item.find(".border-0.rounded").addClass("reject");

                              Swal.fire({
                                  position: 'center',
                                  icon: 'success',
                                  title: "Pengkinian Data telah ditolak.",
                                  showConfirmButton: false,
                                  timer: 3000
                              });

                                
                              }
                          });
                            
                            $('#modalCloseTicket').modal('hide');

                        }
                    });
                }
            });


            $('#btnApprove').click(function(e){

                const reasonApprove = $('#reasoncloseticket').val();
                
                if (reasonApprove == '' || reasonApprove == null) {
                        $('#err-reasoncloseticket').removeClass('d-none');
                    } else {
                        $('#err-reasoncloseticket').addClass('d-none');
                }

                if (
                    reasonApprove != '' 
                  ) {
                Swal.fire({
                    title: "Apakah kamu menyetujui pengajuan ini ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya', 
                    cancelButtonText: 'Tidak',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                          type: 'POST',
                          url: '{{ route('addApproved') }}',
                          data: {
                              modalID,reasonApprove
                          },
                          success: function (response) {
                                
                          ui.item.find(".closed").removeClass("closed");
                          ui.item.find(".border-0.rounded").addClass("approved");

                          Swal.fire({
                              position: 'center',
                              icon: 'success',
                              title: "Pengkinian Data telah disetujui.",
                              showConfirmButton: false,
                              timer: 3000
                          });

                            
                          }
                        });

                        $('#modalCloseTicket').modal('hide');

                    }
                });
              }
            });
            
        },

        remove: function (event, ui) {
            // Mengurangi jumlah kartu dari "Open/Reopen" saat dipindahkan ke "Maintenance in Progress"
            updateTotalItemsLabel("#closed");
        },
    });


    function updateTotalItemsLabel(listId) {
        const totalItems = $(listId).find(".card").length;
        $(listId).closest(".card").find(".total-items-label").text(totalItems);
    }

    function updateTotalTodayAndToDoLabels() {
        const todayListTotal = $("#maintenanceinprogress").find(".card").length;
        const toDoListTotal = $("#openlist").find(".card").length;

        // Update label total "Todo" dan "Today"
        $("#today-label").text(todayListTotal);
        $("#todo-label").text(toDoListTotal);
    }
});

  $('body').on('click', '.detailById', function(e){
      e.preventDefault();
      const id = $(this).data('id');
      if(id){
        window.location.href = `/dataProcess/detail/${id}`;
      }
      console.log(id);
  });


  $('body').on('click', '.detailById2', function(e){
    e.preventDefault()
    const id = $(this).data('id');
    if(id){
      window.location.href = `/dataProcess/detail/${id}`;
    }
    console.log(id);
  })

  $('body').on('click', '.detailById3', function(e){
    e.preventDefault()
    const id = $(this).data('id');
    if(id){
      window.location.href = `/dataProcess/detail/${id}`;
    }
    console.log(id);
  })

  $('body').on('click', '.detailById4', function(e){
    e.preventDefault()
    const id = $(this).data('id');
    if(id){
      window.location.href = `/dataProcess/detail/${id}`;
    }
    console.log(id);
  })

  $('body').on('click', '.detailById5', function(e){
    e.preventDefault()
    const id = $(this).data('id');
    if(id){
      window.location.href = `/dataProcess/detail/${id}`;
    }
    console.log(id);
  })

  



  
  


</script>
@endsection