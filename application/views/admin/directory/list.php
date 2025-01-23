<?php $this->load->view('admin/includes/header'); ?>
<div class="container">
    <div class="page-inner">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Gestion des annuaires</h1>
                <p class="text-muted">Gérez les annuaires de votre site</p>
            </div>
            <a href="<?php echo base_url('admin/directory/add'); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Ajouter un annuaire
            </a>
        </div>

        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control" placeholder="Rechercher...">
                        <button class="btn btn-primary" type="button" id="searchButton">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table tabel-bordred table-hover">
                        <thead>
                            <tr>
                                <th>Logo</th>
                                <th>Nom</th>
                                <th>Site web</th>
                                <th>Localisation</th>
                                <th>Email</th>
                                <th>Statut</th>
                                <th>Portfolio</th>
                                <th style="width: 180px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="directoriesTable">
                            <!-- Table content will be loaded here -->
                        </tbody>
                    </table>
                </div>

                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center" id="pagination">
                        <!-- Pagination will be generated here -->
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<style>
.pagination {
    display: flex;
    padding-left: 0;
    list-style: none;
    gap: 5px;
}

.pagination .page-item .page-link {
    padding: 8px 16px;
    color: #666;
    background-color: #fff;
    border: 1px solid #ddd;
    text-decoration: none;
    border-radius: 20px;
    min-width: 40px;
    text-align: center;
}

.pagination .page-item.active .page-link {
    color: #fff;
    background-color: #0d6efd;
    border-color: #0d6efd;
    font-weight: 500;
}

.pagination .page-item.disabled .page-link {
    color: #999;
    pointer-events: none;
    background-color: #fff;
    border-color: #ddd;
}

.pagination .page-item:hover:not(.active):not(.disabled) .page-link {
    background-color: #f8f9fa;
    border-color: #ddd;
}
</style>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
$(document).ready(function() {
    let currentPage = 1;
    let searchTerm = '';

    function loadDirectories(page = 1, search = '') {
        // Afficher un indicateur de chargement
        $('#directoriesTable').html('<tr><td colspan="7" class="text-center">Chargement...</td></tr>');
        
        $.ajax({
            url: '<?php echo base_url("admin/directory/get_directories_new"); ?>',
            type: 'GET',
            dataType: 'json',
            data: {
                page: page,
                search: search
            },
            success: function(response) {
                console.log('Response:', response); // Debug log
                if (response.error) {
                    $('#directoriesTable').html('<tr><td colspan="7" class="text-center text-danger">Erreur: ' + response.error + '</td></tr>');
                    $('#pagination').empty();
                    return;
                }
                updateTable(response.directories);
                updatePagination(response.current_page, response.total_pages);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                console.log('Response:', xhr.responseText);
                $('#directoriesTable').html('<tr><td colspan="7" class="text-center text-danger">Une erreur est survenue lors du chargement des données</td></tr>');
                $('#pagination').empty();
            }
        });
    }

    function updateTable(directories) {
        let html = '';
        if (!directories || directories.length === 0) {
            html = '<tr><td colspan="7" class="text-center">Aucun annuaire trouvé</td></tr>';
        } else {
            directories.forEach(function(directory) {
                html += `
                    <tr>
                        <td>
                            ${directory.logo ? `<img src="<?php echo base_url('uploads/directories/logos/'); ?>${directory.logo}" alt="Logo" style="height: 30px;">` : '-'}
                        </td>
                        <td>${directory.name || '-'}</td>
                        <td>${directory.website_url ? `<a href="${directory.website_url}" target="_blank">${directory.website_url}</a>` : '-'}</td>
                        <td>${directory.location || '-'}</td>
                        <td>${directory.contact_email || '-'}</td>
                        <td>
                            <span class="badge bg-${directory.status === 'active' ? 'success' : 'danger'}">
                                ${directory.status === 'active' ? 'Actif' : 'Inactif'}
                            </span>
                        </td>
                        <td>
                            <a href="<?php echo base_url('admin/directory/portfolio/'); ?>${directory.id}" class="btn btn-sm btn-primary">
                                <i class="fas fa-images"></i> Portfolio
                            </a>
                            
                        </td>
                        <td>
                            <a href="<?php echo base_url('admin/directory/edit/'); ?>${directory.id}" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger delete-directory" data-id="${directory.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        }
        $('#directoriesTable').html(html);
    }

    function updatePagination(currentPage, totalPages) {
        let html = '';
        
        // Bouton "Previous"
        html += `
            <li class="page-item ${currentPage <= 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>
            </li>
        `;

        // Numéro de page
        html += `
            <li class="page-item ${currentPage === 1 ? 'active' : ''}">
                <a class="page-link" href="#" data-page="1">1</a>
            </li>
        `;

        // Bouton "Next"
        html += `
            <li class="page-item ${currentPage >= totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>
            </li>
        `;

        $('#pagination').html(html);
    }

    // Initial load
    loadDirectories();

    // Search functionality
    let searchTimeout;
    $('#searchInput').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            searchTerm = $(this).val();
            currentPage = 1;
            loadDirectories(currentPage, searchTerm);
        }, 500);
    });

    $('#searchButton').on('click', function() {
        searchTerm = $('#searchInput').val();
        currentPage = 1;
        loadDirectories(currentPage, searchTerm);
    });

    // Pagination click events
    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        if (page && !$(this).parent().hasClass('disabled')) {
            currentPage = page;
            loadDirectories(currentPage, searchTerm);
        }
    });

    // Delete functionality
    $(document).on('click', '.delete-directory', function() {
        if (confirm('Êtes-vous sûr de vouloir supprimer cet annuaire ?')) {
            const id = $(this).data('id');
            $.ajax({
                url: '<?php echo base_url("admin/directory/delete/"); ?>' + id,
                type: 'POST',
                data: {
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function(response) {
                    loadDirectories(currentPage, searchTerm);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
    });
});
</script>

<?php $this->load->view('admin/includes/footer'); ?>
