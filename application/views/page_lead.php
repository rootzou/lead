<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Vue.js & Axios -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-light">
    <div id="app" class="container py-5">
        <!-- Bloc About Us -->
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">{{ aboutUs.title }}</h3>
                <button @click="editMode = !editMode" class="btn btn-warning btn-sm">
                    <span v-if="!editMode">Edit</span>
                    <span v-else>Cancel</span>
                </button>
            </div>
            <div class="card-body">
                <p class="lead">{{ aboutUs.subtitle }}</p>
                
                <div class="mb-3">
                    <img :src="aboutUs.image_url" alt="About Us Image" class="img-fluid rounded">
                </div>

                <ul class="list-group mb-3">
                    <li v-for="point in aboutUs.points" class="list-group-item">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>{{ point }}
                    </li>
                </ul>

                <div v-if="aboutUs.video_url" class="mb-3">
                    <video controls class="w-100 rounded">
                        <source :src="aboutUs.video_url" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>

        <!-- Formulaire d'édition -->
        <div v-if="editMode" class="mt-4">
            <div class="card">
                <div class="card-body">
                    <h4>Éditer les informations</h4>
                    <div class="mb-3">
                        <label class="form-label">Titre</label>
                        <input v-model="aboutUs.title" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sous-titre</label>
                        <textarea v-model="aboutUs.subtitle" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL de l'image</label>
                        <input v-model="aboutUs.image_url" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL de la vidéo</label>
                        <input v-model="aboutUs.video_url" type="text" class="form-control">
                    </div>
                    <button class="btn btn-success" @click="updateContent">Enregistrer les modifications</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS + Icones -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>

    <script>
        new Vue({
            el: "#app",
            data: {
                aboutUs: {},
                editMode: false
            },
            created() {
                this.fetchContent();
            },
            methods: {
                fetchContent() {
                    axios.get('/aboutus/get_content').then(response => {
                        this.aboutUs = response.data;
                    });
                },
                updateContent() {
                    axios.post('/aboutus/update_content', this.aboutUs)
                        .then(response => {
                            alert('Content updated successfully!');
                            this.editMode = false;
                            this.fetchContent();
                        })
                        .catch(error => {
                            console.error("Error updating content: ", error);
                        });
                }
            }
        });
    </script>
</body>
</html>
