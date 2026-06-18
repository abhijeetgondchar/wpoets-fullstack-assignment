<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - DelphianLogic Showcase</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Custom font -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Titillium+Web:wght@600;700&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --brand-primary: #c4351e;
      --brand-secondary: #11324d;
      --brand-third: #f0b91e;
      --brand-fourth: #64b4c8;
      --gray-darker: #2e3439;
      --gray-white: #f6f6f6;
    }
    body {
      font-family: 'Open Sans', sans-serif;
      background-color: #f0f2f5;
      color: #333;
    }
    .navbar {
      background-color: var(--brand-secondary);
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .navbar-brand, .nav-link {
      color: #fff !important;
      font-family: 'Titillium Web', sans-serif;
    }
    .admin-title {
      font-family: 'Titillium Web', sans-serif;
      font-weight: 700;
      color: var(--brand-secondary);
    }
    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      margin-bottom: 30px;
    }
    .card-header {
      background-color: #fff;
      border-bottom: 1px solid #eee;
      font-family: 'Titillium Web', sans-serif;
      font-weight: 600;
      padding: 15px 20px;
    }
    .btn-primary {
      background-color: var(--brand-secondary);
      border-color: var(--brand-secondary);
    }
    .btn-primary:hover {
      background-color: #0c2539;
      border-color: #0c2539;
    }
    .btn-accent {
      background-color: var(--brand-primary);
      color: #fff;
    }
    .btn-accent:hover {
      background-color: #a82d19;
      color: #fff;
    }
    .table img {
      height: 32px;
      object-fit: contain;
    }
    .preview-thumbnail {
      width: 40px;
      height: 40px;
      object-fit: cover;
      border-radius: 4px;
      border: 1px solid #ddd;
    }
    .badge-tab {
      background-color: #e2f0d9;
      color: #385723;
      font-weight: 600;
    }
    .badge-demo-mode {
      background-color: var(--brand-third);
      color: #000;
      font-weight: 700;
    }
    .status-alert {
      border: none;
      border-radius: 8px;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark mb-4">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
        <span>DelphianLogic Admin</span>
      </a>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php" target="_blank">View Live Showcase →</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="admin-title m-0">Content Management</h2>
      <div>
        <button class="btn btn-primary btn-sm me-2" onclick="resetDemoData()">Reset Demo Data</button>
      </div>
    </div>

    <!-- DB Status Notification Banner -->
    <div id="status-banner" class="alert status-alert d-flex align-items-center justify-content-between p-3 mb-4" role="alert">
      <div>
        <strong id="status-title">Checking database connection...</strong>
        <p id="status-desc" class="m-0 small text-secondary">Checking system settings...</p>
      </div>
      <span id="status-badge" class="badge p-2">N/A</span>
    </div>

    <div class="row">
      <!-- Left Column: Manage Tabs -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span>Showcase Tabs</span>
            <button class="btn btn-accent btn-sm py-1" onclick="openTabModal()">+ Add Tab</button>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0" id="tabs-table">
                <thead class="table-light">
                  <tr>
                    <th>Icon</th>
                    <th>Title</th>
                    <th>Sort</th>
                    <th class="text-end">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Filled via AJAX -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: Manage Slides -->
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span>Showcase Slides / Items</span>
            <button class="btn btn-accent btn-sm py-1" onclick="openSlideModal()">+ Add Slide</button>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0" id="slides-table">
                <thead class="table-light">
                  <tr>
                    <th>Image</th>
                    <th>Tab</th>
                    <th>Badge / Title</th>
                    <th>Sort</th>
                    <th class="text-end">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Filled via AJAX -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Tab Modal -->
  <div class="modal fade" id="tabModal" tabindex="-1" aria-labelledby="tabModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="tab-form" onsubmit="saveTab(event)">
        <input type="hidden" id="tab-id" name="id">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="tabModalLabel">Add New Tab</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="tab-title" class="form-label">Tab Title</label>
              <input type="text" class="form-value form-control" id="tab-title" name="title" required placeholder="e.g. Learning">
            </div>
            <div class="mb-3">
              <label for="tab-icon" class="form-label">Tab Icon (SVG)</label>
              <select class="form-value form-select" id="tab-icon" name="icon" required>
                <!-- Filled dynamically with SVG images -->
              </select>
              <div id="tab-icon-preview" class="mt-2 text-center p-2 bg-light rounded" style="display:none;">
                <img src="" height="40" alt="Icon preview">
              </div>
            </div>
            <div class="mb-3">
              <label for="tab-sort" class="form-label">Sort Order</label>
              <input type="number" class="form-value form-control" id="tab-sort" name="sort_order" defaultValue="0" value="0" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Tab</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Slide Modal -->
  <div class="modal fade" id="slideModal" tabindex="-1" aria-labelledby="slideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form id="slide-form" onsubmit="saveSlide(event)">
        <input type="hidden" id="slide-id" name="id">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="slideModalLabel">Add New Slide</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="slide-tab-id" class="form-label">Associated Tab</label>
                  <select class="form-value form-select" id="slide-tab-id" name="tab_id" required>
                    <!-- Filled dynamically -->
                  </select>
                </div>
                <div class="mb-3">
                  <label for="slide-badge" class="form-label">Category Badge</label>
                  <input type="text" class="form-value form-control" id="slide-badge" name="badge" required placeholder="e.g. DIGITAL LEARNING INFRASTRUCTURE">
                </div>
                <div class="mb-3">
                  <label for="slide-title" class="form-label">Slide Title</label>
                  <textarea class="form-value form-control" id="slide-title" name="title" rows="3" required placeholder="e.g. Usability enhancement and training..."></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="slide-image" class="form-label">Slide Image (1:1 Aspect Ratio)</label>
                  <select class="form-value form-select" id="slide-image" name="image" required>
                    <!-- Filled dynamically -->
                  </select>
                  <div id="slide-image-preview" class="mt-2 text-center p-2 bg-light rounded" style="display:none;">
                    <img src="" class="preview-thumbnail" style="width:100px; height:100px;" alt="Image preview">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="slide-btn-text" class="form-label">Button Text</label>
                    <input type="text" class="form-value form-control" id="slide-btn-text" name="button_text" value="Learn More" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="slide-btn-link" class="form-label">Button Link</label>
                    <input type="text" class="form-value form-control" id="slide-btn-link" name="button_link" value="#" required>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="slide-sort" class="form-label">Sort Order</label>
                  <input type="number" class="form-value form-control" id="slide-sort" name="sort_order" defaultValue="0" value="0" required>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Slide</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- jQuery & Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    let isDemoMode = false;
    let localData = { tabs: [], slides: [] };
    let availableImages = [];

    // Static fallback database elements to recreate on reset or initialize
    const defaultData = {
      tabs: [
        { id: 1, title: 'Learning', icon: 'images/DL-learning.svg', sort_order: 1 },
        { id: 2, title: 'Technology', icon: 'images/DL-technology.svg', sort_order: 2 },
        { id: 3, title: 'Communication', icon: 'images/DL-communication.svg', sort_order: 3 }
      ],
      slides: [
        { id: 1, tab_id: 1, badge: 'DIGITAL LEARNING INFRASTRUCTURE', title: 'Usability enhancement and Training for Transaction Portal for Customers', button_text: 'Learn More', button_link: '#', image: 'images/DL-Learning-1.jpg', sort_order: 1 },
        { id: 2, tab_id: 1, badge: 'E-LEARNING METHODOLOGIES', title: 'Interactive training simulations to align distributed departments', button_text: 'Learn More', button_link: '#', image: 'images/DL-Learning-1.jpg', sort_order: 2 },
        { id: 3, tab_id: 2, badge: 'ENTERPRISE TECHNOLOGY PACKAGES', title: 'Cloud infrastructure scaling and workflow digitization for legacy systems', button_text: 'Learn More', button_link: '#', image: 'images/DL-Technology.jpg', sort_order: 1 },
        { id: 4, tab_id: 3, badge: 'STRATEGIC COMMUNICATION', title: 'Brand positioning, workshops, and internal communication strategies', button_text: 'Learn More', button_link: '#', image: 'images/DL-Communication.jpg', sort_order: 1 }
      ]
    };

    $(document).ready(function() {
      // 1. Fetch available images from server
      $.getJSON('api.php?action=list_images', function(response) {
        if (response.status === 'success') {
          availableImages = response.images;
          populateImageDropdowns();
        }
      }).fail(function() {
        // Fallback file list if API is unreachable
        availableImages = [
          'images/DL-learning.svg',
          'images/DL-technology.svg',
          'images/DL-communication.svg',
          'images/DL-Learning-1.jpg',
          'images/DL-Technology.jpg',
          'images/DL-Communication.jpg',
          'images/arrow-right.svg',
          'images/plus-01.svg',
          'images/minus-01.svg'
        ];
        populateImageDropdowns();
      });

      // 2. Fetch active tabs and slides (checking for DB connection status)
      loadData();

      // Dropdown changes trigger image preview
      $('#tab-icon').on('change', function() {
        showPreview('tab-icon-preview', $(this).val());
      });
      $('#slide-image').on('change', function() {
        showPreview('slide-image-preview', $(this).val());
      });
    });

    function populateImageDropdowns() {
      const $tabIconSelect = $('#tab-icon');
      const $slideImageSelect = $('#slide-image');
      
      $tabIconSelect.empty().append('<option value="">-- Select Icon --</option>');
      $slideImageSelect.empty().append('<option value="">-- Select Image --</option>');

      availableImages.forEach(img => {
        const isSvg = img.endsWith('.svg');
        if (isSvg) {
          $tabIconSelect.append(`<option value="${img}">${img.replace('images/', '')}</option>`);
        }
        $slideImageSelect.append(`<option value="${img}">${img.replace('images/', '')}</option>`);
      });
    }

    function showPreview(containerId, value) {
      const $container = $('#' + containerId);
      if (value) {
        $container.find('img').attr('src', value);
        $container.slideDown(200);
      } else {
        $container.slideUp(200);
      }
    }

    function loadData() {
      $.getJSON('api.php?action=get_data', function(response) {
        if (response.status === 'success') {
          if (response.source === 'fallback') {
            enableDemoMode(response.message);
          } else {
            enableLiveMode();
            renderTables(response.tabs, response.slides);
          }
        }
      }).fail(function() {
        enableDemoMode('Connection to backend API failed. Simulating locally.');
      });
    }

    function enableLiveMode() {
      isDemoMode = false;
      $('#status-banner')
        .removeClass('alert-warning')
        .addClass('alert-success bg-opacity-10 text-success border border-success')
        .show();
      $('#status-title').text('System Active: Database Connected');
      $('#status-desc').text('All modifications are saved directly to MySQL in real-time.');
      $('#status-badge')
        .removeClass('badge-demo-mode')
        .addClass('bg-success text-white')
        .text('MySQL LIVE');
    }

    function enableDemoMode(warningMessage) {
      isDemoMode = true;
      $('#status-banner')
        .removeClass('alert-success border-success text-success')
        .addClass('alert-warning bg-opacity-10 text-dark border border-warning')
        .show();
      $('#status-title').text('System Active: Demo Mode');
      $('#status-desc').html(warningMessage + '<br><strong>Changes are saved in browser memory and will display on index.php.</strong>');
      $('#status-badge')
        .removeClass('bg-success text-white')
        .addClass('badge-demo-mode')
        .text('DEMO STORAGE');

      // Load from localStorage or set defaults
      const storedTabs = localStorage.getItem('demo_tabs');
      const storedSlides = localStorage.getItem('demo_slides');
      
      if (storedTabs && storedSlides) {
        localData.tabs = JSON.parse(storedTabs);
        localData.slides = JSON.parse(storedSlides);
      } else {
        localData.tabs = JSON.parse(JSON.stringify(defaultData.tabs));
        localData.slides = JSON.parse(JSON.stringify(defaultData.slides));
        saveLocalData();
      }
      renderTables(localData.tabs, localData.slides);
    }

    function saveLocalData() {
      localStorage.setItem('demo_tabs', JSON.stringify(localData.tabs));
      localStorage.setItem('demo_slides', JSON.stringify(localData.slides));
    }

    function resetDemoData() {
      if (confirm('Are you sure you want to reset all demo storage to initial mockup values?')) {
        localStorage.removeItem('demo_tabs');
        localStorage.removeItem('demo_slides');
        alert('Demo storage has been reset.');
        loadData();
      }
    }

    function renderTables(tabs, slides) {
      // Populate Tab Dropdowns in slide modal
      const $slideTabSelect = $('#slide-tab-id');
      $slideTabSelect.empty().append('<option value="">-- Choose Tab --</option>');
      
      // Render Tabs Table
      const $tabsBody = $('#tabs-table tbody');
      $tabsBody.empty();
      
      // Sort tabs by sort_order
      tabs.sort((a,b) => a.sort_order - b.sort_order);

      tabs.forEach(tab => {
        $slideTabSelect.append(`<option value="${tab.id}">${tab.title}</option>`);
        $tabsBody.append(`
          <tr>
            <td><img src="${tab.icon}" alt="icon" height="24"></td>
            <td><strong>${tab.title}</strong></td>
            <td>${tab.sort_order}</td>
            <td class="text-end">
              <button class="btn btn-outline-secondary btn-sm me-1 py-0 px-2" onclick="editTab(${tab.id})">Edit</button>
              <button class="btn btn-outline-danger btn-sm py-0 px-2" onclick="deleteTab(${tab.id})">Delete</button>
            </td>
          </tr>
        `);
      });

      // Render Slides Table
      const $slidesBody = $('#slides-table tbody');
      $slidesBody.empty();
      
      // Sort slides by sort_order
      slides.sort((a,b) => a.sort_order - b.sort_order);

      slides.forEach(slide => {
        const tab = tabs.find(t => t.id == slide.tab_id);
        const tabTitle = tab ? tab.title : `<span class="text-danger">Orphaned (${slide.tab_id})</span>`;
        $slidesBody.append(`
          <tr>
            <td><img src="${slide.image}" class="preview-thumbnail" alt="slide img"></td>
            <td><span class="badge badge-tab">${tabTitle}</span></td>
            <td>
              <div class="small text-muted font-monospace">${slide.badge}</div>
              <div class="fw-semibold text-truncate" style="max-width: 320px;">${slide.title}</div>
            </td>
            <td>${slide.sort_order}</td>
            <td class="text-end">
              <button class="btn btn-outline-secondary btn-sm me-1 py-0 px-2" onclick="editSlide(${slide.id})">Edit</button>
              <button class="btn btn-outline-danger btn-sm py-0 px-2" onclick="deleteSlide(${slide.id})">Delete</button>
            </td>
          </tr>
        `);
      });
    }

    // ------------------------------------------
    // TAB CRUD FUNCTIONS
    // ------------------------------------------
    
    function openTabModal(tab = null) {
      const $form = $('#tab-form');
      $form[0].reset();
      $('#tab-icon-preview').hide();
      
      if (tab) {
        $('#tabModalLabel').text('Edit Tab');
        $('#tab-id').val(tab.id);
        $('#tab-title').val(tab.title);
        $('#tab-icon').val(tab.icon).trigger('change');
        $('#tab-sort').val(tab.sort_order);
      } else {
        $('#tabModalLabel').text('Add New Tab');
        $('#tab-id').val('');
        $('#tab-sort').val(0);
      }
      
      const modal = new bootstrap.Modal(document.getElementById('tabModal'));
      modal.show();
    }

    function editTab(id) {
      if (isDemoMode) {
        const tab = localData.tabs.find(t => t.id == id);
        if (tab) openTabModal(tab);
      } else {
        $.getJSON('api.php?action=get_data', function(response) {
          const tab = response.tabs.find(t => t.id == id);
          if (tab) openTabModal(tab);
        });
      }
    }

    function saveTab(e) {
      e.preventDefault();
      const id = $('#tab-id').val();
      const title = $('#tab-title').val();
      const icon = $('#tab-icon').val();
      const sort_order = parseInt($('#tab-sort').val()) || 0;

      if (isDemoMode) {
        if (id) {
          // Update
          const idx = localData.tabs.findIndex(t => t.id == id);
          if (idx !== -1) {
            localData.tabs[idx] = { id: parseInt(id), title, icon, sort_order };
          }
        } else {
          // Create
          const newId = localData.tabs.length > 0 ? Math.max(...localData.tabs.map(t => t.id)) + 1 : 1;
          localData.tabs.push({ id: newId, title, icon, sort_order });
        }
        saveLocalData();
        bootstrap.Modal.getInstance(document.getElementById('tabModal')).hide();
        renderTables(localData.tabs, localData.slides);
      } else {
        const action = id ? 'update_tab' : 'create_tab';
        const payload = { action, id, title, icon, sort_order };
        
        $.post('api.php', JSON.stringify(payload), function(response) {
          if (response.status === 'success') {
            bootstrap.Modal.getInstance(document.getElementById('tabModal')).hide();
            loadData();
          } else {
            alert('Error: ' + response.message);
          }
        }, 'json');
      }
    }

    function deleteTab(id) {
      if (!confirm('Are you sure you want to delete this Tab? Deleting the tab will also remove all its slides.')) {
        return;
      }

      if (isDemoMode) {
        localData.tabs = localData.tabs.filter(t => t.id != id);
        localData.slides = localData.slides.filter(s => s.tab_id != id);
        saveLocalData();
        renderTables(localData.tabs, localData.slides);
      } else {
        $.post('api.php', JSON.stringify({ action: 'delete_tab', id }), function(response) {
          if (response.status === 'success') {
            loadData();
          } else {
            alert('Error: ' + response.message);
          }
        }, 'json');
      }
    }

    // ------------------------------------------
    // SLIDE CRUD FUNCTIONS
    // ------------------------------------------
    
    function openSlideModal(slide = null) {
      const $form = $('#slide-form');
      $form[0].reset();
      $('#slide-image-preview').hide();
      
      // Ensure there are tabs available
      const tabsCount = $('#slide-tab-id option').length;
      if (tabsCount <= 1) {
        alert('Please create at least one Tab first before creating a Slide.');
        return;
      }

      if (slide) {
        $('#slideModalLabel').text('Edit Slide');
        $('#slide-id').val(slide.id);
        $('#slide-tab-id').val(slide.tab_id);
        $('#slide-badge').val(slide.badge);
        $('#slide-title').val(slide.title);
        $('#slide-image').val(slide.image).trigger('change');
        $('#slide-btn-text').val(slide.button_text);
        $('#slide-btn-link').val(slide.button_link);
        $('#slide-sort').val(slide.sort_order);
      } else {
        $('#slideModalLabel').text('Add New Slide');
        $('#slide-id').val('');
        $('#slide-sort').val(0);
        $('#slide-btn-text').val('Learn More');
        $('#slide-btn-link').val('#');
      }
      
      const modal = new bootstrap.Modal(document.getElementById('slideModal'));
      modal.show();
    }

    function editSlide(id) {
      if (isDemoMode) {
        const slide = localData.slides.find(s => s.id == id);
        if (slide) openSlideModal(slide);
      } else {
        $.getJSON('api.php?action=get_data', function(response) {
          const slide = response.slides.find(s => s.id == id);
          if (slide) openSlideModal(slide);
        });
      }
    }

    function saveSlide(e) {
      e.preventDefault();
      const id = $('#slide-id').val();
      const tab_id = parseInt($('#slide-tab-id').val());
      const badge = $('#slide-badge').val();
      const title = $('#slide-title').val();
      const image = $('#slide-image').val();
      const button_text = $('#slide-btn-text').val();
      const button_link = $('#slide-btn-link').val();
      const sort_order = parseInt($('#slide-sort').val()) || 0;

      if (isDemoMode) {
        if (id) {
          // Update
          const idx = localData.slides.findIndex(s => s.id == id);
          if (idx !== -1) {
            localData.slides[idx] = { id: parseInt(id), tab_id, badge, title, image, button_text, button_link, sort_order };
          }
        } else {
          // Create
          const newId = localData.slides.length > 0 ? Math.max(...localData.slides.map(s => s.id)) + 1 : 1;
          localData.slides.push({ id: newId, tab_id, badge, title, image, button_text, button_link, sort_order });
        }
        saveLocalData();
        bootstrap.Modal.getInstance(document.getElementById('slideModal')).hide();
        renderTables(localData.tabs, localData.slides);
      } else {
        const action = id ? 'update_slide' : 'create_slide';
        const payload = { action, id, tab_id, badge, title, image, button_text, button_link, sort_order };
        
        $.post('api.php', JSON.stringify(payload), function(response) {
          if (response.status === 'success') {
            bootstrap.Modal.getInstance(document.getElementById('slideModal')).hide();
            loadData();
          } else {
            alert('Error: ' + response.message);
          }
        }, 'json');
      }
    }

    function deleteSlide(id) {
      if (!confirm('Are you sure you want to delete this Slide?')) {
        return;
      }

      if (isDemoMode) {
        localData.slides = localData.slides.filter(s => s.id != id);
        saveLocalData();
        renderTables(localData.tabs, localData.slides);
      } else {
        $.post('api.php', JSON.stringify({ action: 'delete_slide', id }), function(response) {
          if (response.status === 'success') {
            loadData();
          } else {
            alert('Error: ' + response.message);
          }
        }, 'json');
      }
    }
  </script>
</body>
</html>
