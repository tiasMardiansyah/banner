<!-- Modal-->
<?php $this->load->view('admin_panel/banner/modal') ?>

<!-- main content -->
<div class="card card-custom card-sticky" id="kt_page_sticky_card">
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-label">
				Banner
			</h3>
		</div>

		<div class="card-toolbar">
			<button
				id="add_data_btn"
                type="button" 
                onclick="openModal()" 
                class="btn btn-light-primary"
            >
				<i class="flaticon-add"></i> Tambah data
			</button>
		</div>
	</div>	
	<div class="card-body">
		<table class="table table-bordered" id="myTable">
			<thead>
				<tr>
					<th class="text-center">No</th>
					<th>Gambar Banner</th>
					<th class="text-center" style="width: 125px;">Aksi</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<script>
	let table
    const context = 'Banner'

	$(document).ready(() => {
        const tableConfig = {
			order: [
				[0, 'asc']
			],
            columnDefs: [
                { className: 'text-center', targets: 0 },
                {
					orderable: false,
					targets: 1,
					render: (data, type, row, meta) => {
						return `<img src='<?= base_url() . 'assets/media/images/foto_banner/' ?>${data}' width="100px"  />`
					}
				},
                {
                    targets: 2,
                    orderable: false,
                    className: 'text-center',
                    render: (data, type, row, meta) => {
                        const editBTN   = renderTableEditBTN(row[2], "<?= base_url() . 'admin_panel/banner/edit' ?>", res => {
                            const data = res.data 
                
                            openModal({mode: 'update'})
                            $('#data_id').val(data.id)
							$(`input[name='old_banner']`).val(data.img)
							
							const imgPath = '<?= base_url() . 'assets/media/images/foto_banner/' ?>' + data.img
							hideUpload(imgPath)
                        })
                        const deleteBTN = renderTableDeleteBTN(row[2], "<?= base_url() . 'admin_panel/banner/destroy' ?>")

                        
                            return editBTN + deleteBTN
                    }
                }
            ]
		} 
        
        table = initializeDataTable('#myTable', '<?= base_url() . 'admin_panel/banner/dat_list' ?>', tableConfig)
	})

	$( "#add_data_btn" ).on('click', function(){
        showUpload()
		$(`input[name='old_cover']`).val('')
    })
</script>
<script src="<?= base_url() . 'assets/js/crud/generalModalCRUD.js?version=1.3' ?>"></script>