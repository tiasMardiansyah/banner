<div class="modal fade" id="Modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel"></h5>
            </div>

            <form id="ModalForm" autocomplete="off">
                <div class="modal-body">
                    <input type="text" id="data_id" class="d-none" name="id">
                    <input type="text" name="old_banner" class="d-none" placeholder="old cover">

                    <div class="form-group align-items-center ">
                            <div
                                id="custom_upload_container"
                                class="col-md-12 rounded"
                                style="
                                    padding: 20px;
                                    text-align: center;
                                    border: 2px dashed #ebedf3;
                                "
                            >
                                <div id="img_selector_wrapper" <?= isset($mode) && $mode == 'edit' ? "class='d-none'" : '' ?> >
                                    <input
                                        type="file"
                                        name="cover"
                                        class="d-none"
                                        id="select_cover"
                                        accept="image/png, image/gif, image/jpeg"
                                        
                                    />
                                    <i class="flaticon2-download display-3"></i>

                                    <h3
                                        class="mt-5 mb-1"
                                        style="
                                            color: #3f4254;
                                            padding: 0;
                                            font-weight: 500;
                                            font-size: 1.2rem;
                                        "
                                    >
                                        Pilih file untuk di upload
                                    </h3>
                                    <small
                                        class="d-block mb-8"
                                        style="color: #b5b5c3; font-weight: 400"
                                        >Hanya file gambar, png, jpg dan jpeg yang diperbolehkan
                                        untuk diunggah</small
                                    >

                                    <button onclick="chooseFile()" type="button" class="btn btn-primary">
                                        Pilih file
                                    </button>
                                </div>
                                <div id="img_preview" class="<?= isset($mode) && $mode == 'edit' ? 'd-flex' : 'd-none' ?> flex-column align-items-center">
                                    <div class="mb-2 rounded shadow-sm" style="overflow: hidden">
                                        <img
                                            style="width: 120px; height: 120px; object-fit: cover"
                                            alt=""
                                            src="<?= isset($mode) && $mode == 'edit' ? base_url() . 'assets/media/images/galeri/' . $cover : '#' ?>"
                                        />
                                    </div>
                                    <a
                                        href="javascript:undefined;"
                                        style="
                                            color: #7e8299;
                                            font-size: 0.9rem;
                                            font-weight: 500;
                                            font-weight: 500;
                                        "
                                        onclick="showUpload()"
                                        >Hapus gambar</a
                                    >
                                </div>
                            </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="cancel_btn" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" id="save_btn" onclick="save('<?= base_url() . 'admin_panel/banner/save' ?>', true)" class="btn btn-primary font-weight-bold">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    const chooseFile = () => {
        $('#select_cover').click()
    }

    const hideUpload = (imgSource) => {
        $('#img_preview').removeClass('d-none')
        $('#img_preview').addClass('d-flex')

        $( '#img_preview img' ).attr( 'src', imgSource )

        $('#img_selector_wrapper').addClass('d-none')
    }

    const showUpload = () => {
        $('#img_preview').removeClass('d-flex')
        $('#img_preview').addClass('d-none')

        $('input[name="cover"]').val('')
        $( '#img_preview img' ).attr( 'src', '#' )

        $('#img_selector_wrapper').removeClass('d-none')
    }


    const hideCustomUploadInvalidMSG = () => {
        $('#invalid_custom_upload_msg').addClass('d-none')
        $('#custom_upload_container').removeClass('invalid-custom-upload')
    }

    const showCustomUploadInvalidMSG = () => {
		$('#invalid_custom_upload_msg').removeClass('d-none')
		$('#custom_upload_container').addClass('invalid-custom-upload')
	}


    $('input[name="cover"]').on('change', e => {
        const src = URL.createObjectURL( e.target.files[0] )

        hideCustomUploadInvalidMSG()
        hideUpload(src)
    })
</script>