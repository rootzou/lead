<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Statistics</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .edit-form { display: none; }
        .edit-button, .visibility-button { 
            margin: 10px 5px;
            padding: 5px 15px;
            cursor: pointer;
        }
        .hidden-content { 
            display: none !important;
        }
        .content-display {
            transition: all 0.3s ease;
        }
        .stats-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }
        .stat-item {
            flex: 1;
            min-width: 200px;
            padding: 20px;
            text-align: center;
            background: #f5f5f5;
            border-radius: 8px;
        }
        .stat-number {
            font-size: 2.5em;
            font-weight: bold;
            color: #2c3e50;
        }
        .stat-text {
            color: #7f8c8d;
            margin-top: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
        }
    </style>
</head>
<body>
    <div class="content-display <?php echo (isset($statistics['is_visible']) && $statistics['is_visible'] == 0) ? 'hidden-content' : ''; ?>">
        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-number"><?php echo isset($statistics['happy_clients_count']) ? $statistics['happy_clients_count'] : '0'; ?></div>
                <div class="stat-text">Happy Clients</div>
                <div class="stat-subtext"><?php echo isset($statistics['happy_clients_text']) ? $statistics['happy_clients_text'] : ''; ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo isset($statistics['projects_count']) ? $statistics['projects_count'] : '0'; ?></div>
                <div class="stat-text">Projects</div>
                <div class="stat-subtext"><?php echo isset($statistics['projects_text']) ? $statistics['projects_text'] : ''; ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo isset($statistics['support_hours_count']) ? $statistics['support_hours_count'] : '0'; ?></div>
                <div class="stat-text">Hours Of Support</div>
                <div class="stat-subtext"><?php echo isset($statistics['support_hours_text']) ? $statistics['support_hours_text'] : ''; ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo isset($statistics['workers_count']) ? $statistics['workers_count'] : '0'; ?></div>
                <div class="stat-text">Hard Workers</div>
                <div class="stat-subtext"><?php echo isset($statistics['workers_text']) ? $statistics['workers_text'] : ''; ?></div>
            </div>
        </div>
    </div>

    <div class="controls">
        <button class="edit-button">Edit</button>
        <button class="visibility-button" data-visible="<?php echo isset($statistics['is_visible']) ? $statistics['is_visible'] : '1'; ?>">
            <?php echo (isset($statistics['is_visible']) && $statistics['is_visible'] == 0) ? 'Show Block' : 'Hide Block'; ?>
        </button>
    </div>

    <div class="edit-form">
        <form id="statisticsForm">
            <div class="form-group">
                <label>Happy Clients:</label>
                <input type="number" name="happy_clients_count" value="<?php echo isset($statistics['happy_clients_count']) ? $statistics['happy_clients_count'] : ''; ?>">
                <input type="text" name="happy_clients_text" placeholder="Description text" value="<?php echo isset($statistics['happy_clients_text']) ? htmlspecialchars($statistics['happy_clients_text']) : ''; ?>">
            </div>
            <div class="form-group">
                <label>Projects:</label>
                <input type="number" name="projects_count" value="<?php echo isset($statistics['projects_count']) ? $statistics['projects_count'] : ''; ?>">
                <input type="text" name="projects_text" placeholder="Description text" value="<?php echo isset($statistics['projects_text']) ? htmlspecialchars($statistics['projects_text']) : ''; ?>">
            </div>
            <div class="form-group">
                <label>Hours of Support:</label>
                <input type="number" name="support_hours_count" value="<?php echo isset($statistics['support_hours_count']) ? $statistics['support_hours_count'] : ''; ?>">
                <input type="text" name="support_hours_text" placeholder="Description text" value="<?php echo isset($statistics['support_hours_text']) ? htmlspecialchars($statistics['support_hours_text']) : ''; ?>">
            </div>
            <div class="form-group">
                <label>Hard Workers:</label>
                <input type="number" name="workers_count" value="<?php echo isset($statistics['workers_count']) ? $statistics['workers_count'] : ''; ?>">
                <input type="text" name="workers_text" placeholder="Description text" value="<?php echo isset($statistics['workers_text']) ? htmlspecialchars($statistics['workers_text']) : ''; ?>">
            </div>
            <button type="submit">Save Changes</button>
        </form>
    </div>

    <script>
    $(document).ready(function() {
        $('.edit-button').click(function() {
            $('.edit-form').toggle();
        });

        $('.visibility-button').click(function() {
            var button = $(this);
            var currentlyVisible = button.data('visible') == '1';
            var newVisibility = currentlyVisible ? '0' : '1';

            $.ajax({
                url: '<?php echo site_url("statistics/toggle_visibility"); ?>',
                type: 'POST',
                data: { visible: newVisibility },
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        button.data('visible', newVisibility);
                        button.text(newVisibility == '1' ? 'Hide Block' : 'Show Block');
                        $('.content-display').toggleClass('hidden-content');
                    } else {
                        alert('Error updating visibility');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    console.error('Status:', status);
                    console.error('Response:', xhr.responseText);
                    alert('Error connecting to server. Please check the console for details.');
                }
            });
        });

        $('#statisticsForm').submit(function(e) {
            e.preventDefault();
            
            var formData = {
                happy_clients_count: $('input[name="happy_clients_count"]').val(),
                happy_clients_text: $('input[name="happy_clients_text"]').val(),
                projects_count: $('input[name="projects_count"]').val(),
                projects_text: $('input[name="projects_text"]').val(),
                support_hours_count: $('input[name="support_hours_count"]').val(),
                support_hours_text: $('input[name="support_hours_text"]').val(),
                workers_count: $('input[name="workers_count"]').val(),
                workers_text: $('input[name="workers_text"]').val()
            };

            $.ajax({
                url: '<?php echo site_url("statistics/update_content"); ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        location.reload();
                    } else {
                        alert('Error updating content');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    console.error('Status:', status);
                    console.error('Response:', xhr.responseText);
                    alert('Error connecting to server. Please check the console for details.');
                }
            });
        });
    });
    </script>
</body>
</html>
