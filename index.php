<?php
require_once __DIR__ . '/db.php';

// Safe fallback data matching the style guide and mockups
$fallbackData = [
    'tabs' => [
        ['id' => 1, 'title' => 'Learning', 'icon' => 'images/DL-learning.svg', 'sort_order' => 1],
        ['id' => 2, 'title' => 'Technology', 'icon' => 'images/DL-technology.svg', 'sort_order' => 2],
        ['id' => 3, 'title' => 'Communication', 'icon' => 'images/DL-communication.svg', 'sort_order' => 3]
    ],
    'slides' => [
        ['id' => 1, 'tab_id' => 1, 'badge' => 'DIGITAL LEARNING INFRASTRUCTURE', 'title' => 'Usability enhancement and Training for Transaction Portal for Customers', 'button_text' => 'Learn More', 'button_link' => '#', 'image' => 'images/DL-Learning-1.jpg', 'sort_order' => 1],
        ['id' => 2, 'tab_id' => 1, 'badge' => 'E-LEARNING METHODOLOGIES', 'title' => 'Interactive training simulations to align distributed departments', 'button_text' => 'Learn More', 'button_link' => '#', 'image' => 'images/DL-Learning-1.jpg', 'sort_order' => 2],
        ['id' => 3, 'tab_id' => 2, 'badge' => 'ENTERPRISE TECHNOLOGY PACKAGES', 'title' => 'Cloud infrastructure scaling and workflow digitization for legacy systems', 'button_text' => 'Learn More', 'button_link' => '#', 'image' => 'images/DL-Technology.jpg', 'sort_order' => 1],
        ['id' => 4, 'tab_id' => 3, 'badge' => 'STRATEGIC COMMUNICATION', 'title' => 'Brand positioning, workshops, and internal communication strategies', 'button_text' => 'Learn More', 'button_link' => '#', 'image' => 'images/DL-Communication.jpg', 'sort_order' => 1]
    ]
];

$tabs = [];
$slides = [];
$isDbConnection = true;

try {
    $db = getDbConnection();
    $stmt = $db->query("SELECT * FROM tabs ORDER BY sort_order ASC, id ASC");
    $tabs = $stmt->fetchAll();
    
    $stmt = $db->query("SELECT * FROM slides ORDER BY sort_order ASC, id ASC");
    $slides = $stmt->fetchAll();
} catch (Exception $e) {
    $isDbConnection = false;
    $tabs = $fallbackData['tabs'];
    $slides = $fallbackData['slides'];
}

// Group slides by tab ID for easier rendering
$groupedSlides = [];
foreach ($tabs as $tab) {
    $groupedSlides[$tab['id']] = [];
}
foreach ($slides as $slide) {
    if (isset($groupedSlides[$slide['tab_id']])) {
        $groupedSlides[$slide['tab_id']][] = $slide;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Explore DelphianLogic in Action: Learning, Technology, and Strategic Communication solutions.">
  <title>DelphianLogic in Action</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Custom Stylesheet -->
  <link href="style.css" rel="stylesheet">
</head>
<body>

  <!-- Public Showcase Section -->
  <section class="wpoets-showcase-section" aria-label="WPoets Showcase Section">
    
    <!-- Header Area -->
    <header class="showcase-header">
      <h2>DelphianLogic in Action</h2>
       <p>
        Discover how DelphianLogic transforms learning experiences through innovative digital solutions,
        interactive content, and technology-driven education designed to engage learners and deliver measurable outcomes.
      </p>
      <?php if (!$isDbConnection): ?>
        <div class="alert alert-warning d-inline-block py-1 px-3 mt-3" style="font-size: 13px; border-radius: var(--br-5); border: none;">
          <strong>Notice:</strong> Database offline. Displaying static mock data fallback.
        </div>
      <?php endif; ?>
    </header>
    
    <div class="showcase-container">
      
      <!-- Desktop 3-Column Layout -->
      <div class="showcase-row">
        
        <!-- Column 1: Vertical Tabs -->
        <nav class="showcase-tabs-col" aria-label="Vertical navigation tabs">
          <?php foreach ($tabs as $index => $tab): ?>
            <button class="tab-btn <?php echo $index === 0 ? 'active' : ''; ?>" data-tab-id="<?php echo $tab['id']; ?>" id="tab-btn-<?php echo $tab['id']; ?>">
              <span class="tab-icon">
                <img src="<?php echo htmlspecialchars($tab['icon']); ?>" alt="<?php echo htmlspecialchars($tab['title']); ?> Icon">
              </span>
              <span class="tab-title"><?php echo htmlspecialchars($tab['title']); ?></span>
            </button>
          <?php endforeach; ?>
        </nav>
        
        <!-- Column 2: Slider Content -->
        <main class="showcase-slider-col">
          <div class="slide-content-wrapper">
            <?php 
            $firstSlideGlobal = true;
            foreach ($tabs as $tIdx => $tab):
                $tabSlides = $groupedSlides[$tab['id']];
                foreach ($tabSlides as $sIdx => $slide):
            ?>
              <div class="slide-item <?php echo ($firstSlideGlobal) ? 'active' : ''; ?>" 
                   data-tab-id="<?php echo $tab['id']; ?>" 
                   data-slide-index="<?php echo $sIdx; ?>"
                   id="slide-item-<?php echo $tab['id']; ?>-<?php echo $sIdx; ?>">
                <span class="slide-badge"><?php echo htmlspecialchars($slide['badge']); ?></span>
                <h3 class="slide-title"><?php echo htmlspecialchars($slide['title']); ?></h3>
                <a href="<?php echo htmlspecialchars($slide['button_link']); ?>" class="slide-btn">
                  <?php echo htmlspecialchars($slide['button_text']); ?> 
                  <img src="images/arrow-right.svg" alt="Right Arrow">
                </a>
              </div>
            <?php 
                $firstSlideGlobal = false;
                endforeach;
            endforeach; 
            ?>
          </div>
          
          <!-- Slider Navigation Arrows -->
          <div class="slider-nav">
            <button class="nav-arrow nav-prev" aria-label="Previous slide">
              <img src="images/arrow-right.svg" alt="Prev Arrow">
            </button>
            <button class="nav-arrow nav-next" aria-label="Next slide">
              <img src="images/arrow-right.svg" alt="Next Arrow">
            </button>
          </div>
          
          <!-- Slider Pagination Dots -->
          <div class="slider-pagination" role="tablist">
            <!-- Dynamically populated/updated by JS -->
          </div>
        </main>
        
        <!-- Column 3: Slider Image (1:1 Ratio) -->
        <aside class="showcase-image-col" aria-label="Showcase images">
          <div class="image-wrapper">
            <?php 
            $firstImgGlobal = true;
            foreach ($tabs as $tab):
                $tabSlides = $groupedSlides[$tab['id']];
                foreach ($tabSlides as $sIdx => $slide):
            ?>
              <img src="<?php echo htmlspecialchars($slide['image']); ?>" 
                   alt="<?php echo htmlspecialchars($slide['title']); ?>" 
                   class="slide-img <?php echo ($firstImgGlobal) ? 'active' : ''; ?>"
                   data-tab-id="<?php echo $tab['id']; ?>"
                   data-slide-index="<?php echo $sIdx; ?>"
                   id="slide-img-<?php echo $tab['id']; ?>-<?php echo $sIdx; ?>">
            <?php 
                $firstImgGlobal = false;
                endforeach;
            endforeach; 
            ?>
          </div>
        </aside>
        
      </div>
      
      <!-- Mobile Accordion Layout -->
      <div class="showcase-accordion" id="showcase-accordion-container">
        <?php foreach ($tabs as $index => $tab): ?>
          <div class="acc-item <?php echo $index === 0 ? 'active' : ''; ?>" data-tab-id="<?php echo $tab['id']; ?>">
            
            <!-- Accordion Header -->
            <div class="acc-header">
              <div class="acc-header-left">
                <span class="tab-icon">
                  <img src="<?php echo htmlspecialchars($tab['icon']); ?>" alt="<?php echo htmlspecialchars($tab['title']); ?> Icon">
                </span>
                <span class="acc-title"><?php echo htmlspecialchars($tab['title']); ?></span>
              </div>
              <button class="acc-toggle-btn" aria-label="Toggle panel">
                <img src="<?php echo $index === 0 ? 'images/minus-01.svg' : 'images/plus-01.svg'; ?>" class="toggle-icon" alt="Toggle">
              </button>
            </div>
            
            <!-- Accordion Expanded Content (Overlay Slider) -->
            <div class="acc-content" style="<?php echo $index === 0 ? 'display: block;' : 'display: none;'; ?>">
              <div class="acc-content-overlay">
                <?php 
                $tabSlides = $groupedSlides[$tab['id']];
                if (empty($tabSlides)): 
                ?>
                  <div class="text-white">No slides available for this tab.</div>
                <?php else: ?>
                  
                  <div class="mobile-slide-wrapper w-100 position-relative">
                    <?php foreach ($tabSlides as $sIdx => $slide): ?>
                      <div class="mobile-slide-item text-center <?php echo $sIdx === 0 ? 'active' : 'd-none'; ?>" data-slide-index="<?php echo $sIdx; ?>" data-image="<?php echo htmlspecialchars($slide['image']); ?>">
                        <span class="slide-badge"><?php echo htmlspecialchars($slide['badge']); ?></span>
                        <h4 class="slide-title px-3"><?php echo htmlspecialchars($slide['title']); ?></h4>
                        <a href="<?php echo htmlspecialchars($slide['button_link']); ?>" class="slide-btn">
                          <?php echo htmlspecialchars($slide['button_text']); ?> 
                          <img src="images/arrow-right.svg" alt="Right Arrow">
                        </a>
                      </div>
                    <?php endforeach; ?>
                  </div>
                  
                  <!-- Mobile slider pagination dots -->
                  <div class="mobile-slider-pagination mt-4 d-flex justify-content-center gap-2">
                    <?php foreach ($tabSlides as $sIdx => $slide): ?>
                      <button class="dot <?php echo $sIdx === 0 ? 'active' : ''; ?>" data-slide-index="<?php echo $sIdx; ?>" aria-label="Go to slide <?php echo $sIdx + 1; ?>"></button>
                    <?php endforeach; ?>
                  </div>
                  
                <?php endif; ?>
              </div>
            </div>
            
          </div>
        <?php endforeach; ?>
      </div>
      
    </div>
  </section>

  <!-- jQuery & Bootstrap Bundle -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    $(document).ready(function() {
      // ------------------------------------------
      // DEMO MODE LOCALSTORAGE OVERRIDE
      // ------------------------------------------
      const isDbConnected = <?php echo $isDbConnection ? 'true' : 'false'; ?>;
      let tabsData = <?php echo json_encode($tabs); ?>;
      let slidesData = <?php echo json_encode($slides); ?>;
      
      if (!isDbConnected) {
        const storedTabs = localStorage.getItem('demo_tabs');
        const storedSlides = localStorage.getItem('demo_slides');
        if (storedTabs && storedSlides) {
          tabsData = JSON.parse(storedTabs);
          slidesData = JSON.parse(storedSlides);
          
          // Sort data by sort_order
          tabsData.sort((a, b) => (a.sort_order || 0) - (b.sort_order || 0));
          slidesData.sort((a, b) => (a.sort_order || 0) - (b.sort_order || 0));
          
          // Re-render desktop vertical tabs
          const $tabsCol = $('.showcase-tabs-col');
          $tabsCol.empty();
          tabsData.forEach((tab, index) => {
            const activeClass = index === 0 ? 'active' : '';
            $tabsCol.append(`
              <button class="tab-btn ${activeClass}" data-tab-id="${tab.id}" id="tab-btn-${tab.id}">
                <span class="tab-icon">
                  <img src="${tab.icon}" alt="${tab.title} Icon">
                </span>
                <span class="tab-title">${tab.title}</span>
              </button>
            `);
          });
          
          // Re-render desktop slides (Column 2)
          const $slidesCol = $('.slide-content-wrapper');
          $slidesCol.empty();
          
          // Re-render desktop images (Column 3)
          const $imageCol = $('.image-wrapper');
          $imageCol.empty();
          
          let firstSlideGlobal = true;
          tabsData.forEach(tab => {
            const tabSlides = slidesData.filter(s => s.tab_id == tab.id);
            tabSlides.forEach((slide, sIdx) => {
              const activeClass = firstSlideGlobal ? 'active' : '';
              const displayStyle = firstSlideGlobal ? 'display: flex;' : 'display: none;';
              
              // Slide content
              $slidesCol.append(`
                <div class="slide-item ${activeClass}" 
                     data-tab-id="${tab.id}" 
                     data-slide-index="${sIdx}"
                     id="slide-item-${tab.id}-${sIdx}"
                     style="${displayStyle}">
                  <span class="slide-badge">${slide.badge}</span>
                  <h3 class="slide-title">${slide.title}</h3>
                  <a href="${slide.button_link}" class="slide-btn">
                    ${slide.button_text} 
                    <img src="images/arrow-right.svg" alt="Right Arrow">
                  </a>
                </div>
              `);
              
              // Slide image
              $imageCol.append(`
                <img src="${slide.image}" 
                     alt="${slide.title}" 
                     class="slide-img ${activeClass}"
                     data-tab-id="${tab.id}"
                     data-slide-index="${sIdx}"
                     id="slide-img-${tab.id}-${sIdx}">
              `);
              
              firstSlideGlobal = false;
            });
          });
          
          // Re-render mobile accordion
          const $accordionContainer = $('#showcase-accordion-container');
          $accordionContainer.empty();
          
          tabsData.forEach((tab, index) => {
            const activeClass = index === 0 ? 'active' : '';
            const displayStyle = index === 0 ? 'display: block;' : 'display: none;';
            const toggleIcon = index === 0 ? 'images/minus-01.svg' : 'images/plus-01.svg';
            const tabSlides = slidesData.filter(s => s.tab_id == tab.id);
            
            let accordionContentHtml = '';
            if (tabSlides.length === 0) {
              accordionContentHtml = '<div class="text-white">No slides available for this tab.</div>';
            } else {
              let slidesHtml = '';
              let dotsHtml = '';
              
              tabSlides.forEach((slide, sIdx) => {
                const itemActiveClass = sIdx === 0 ? 'active' : 'd-none';
                const dotActiveClass = sIdx === 0 ? 'active' : '';
                
                slidesHtml += `
                  <div class="mobile-slide-item text-center ${itemActiveClass}" data-slide-index="${sIdx}" data-image="${slide.image}">
                    <span class="slide-badge">${slide.badge}</span>
                    <h4 class="slide-title px-3">${slide.title}</h4>
                    <a href="${slide.button_link}" class="slide-btn">
                      ${slide.button_text} 
                      <img src="images/arrow-right.svg" alt="Right Arrow">
                    </a>
                  </div>
                `;
                
                dotsHtml += `
                  <button class="dot ${dotActiveClass}" data-slide-index="${sIdx}" aria-label="Go to slide ${sIdx + 1}"></button>
                `;
              });
              
              accordionContentHtml = `
                <div class="mobile-slide-wrapper w-100 position-relative">
                  ${slidesHtml}
                </div>
                <div class="mobile-slider-pagination mt-4 d-flex justify-content-center gap-2">
                  ${dotsHtml}
                </div>
              `;
            }
            
            $accordionContainer.append(`
              <div class="acc-item ${activeClass}" data-tab-id="${tab.id}">
                <div class="acc-header">
                  <div class="acc-header-left">
                    <span class="tab-icon">
                      <img src="${tab.icon}" alt="${tab.title} Icon">
                    </span>
                    <span class="acc-title">${tab.title}</span>
                  </div>
                  <button class="acc-toggle-btn" aria-label="Toggle panel">
                    <img src="${toggleIcon}" class="toggle-icon" alt="Toggle">
                  </button>
                </div>
                <div class="acc-content" style="${displayStyle}">
                  <div class="acc-content-overlay">
                    ${accordionContentHtml}
                  </div>
                </div>
              </div>
            `);
          });
        } else {
          localStorage.setItem('demo_tabs', JSON.stringify(tabsData));
          localStorage.setItem('demo_slides', JSON.stringify(slidesData));
        }
      }

      // ------------------------------------------
      // DESKTOP INTERACTIVITY (TABS & SLIDERS)
      // ------------------------------------------
      
      let activeTabId = parseInt($('.tab-btn.active').data('tab-id')) || 1;
      let activeSlideIndexes = {}; // Stores the current active slide index for each tab
      
      // Initialize active slide indices for each tab to 0
      $('.tab-btn').each(function() {
        let tId = $(this).data('tab-id');
        activeSlideIndexes[tId] = 0;
      });

      // Render pagination dots for current active tab
      function renderPagination() {
        const $dotsContainer = $('.slider-pagination');
        $dotsContainer.empty();
        
        // Count slides for active tab
        const slidesCount = $(`.slide-item[data-tab-id="${activeTabId}"]`).length;
        if (slidesCount <= 1) {
          $dotsContainer.hide();
          $('.slider-nav').hide();
          return;
        } else {
          $dotsContainer.show();
          $('.slider-nav').show();
        }
        
        const currentIndex = activeSlideIndexes[activeTabId];
        for (let i = 0; i < slidesCount; i++) {
          const activeClass = i === currentIndex ? 'active' : '';
          $dotsContainer.append(`<button class="dot ${activeClass}" data-index="${i}" aria-label="Go to slide ${i + 1}"></button>`);
        }
      }

      // Show slide (updating content and image) for active tab
      function showSlide(index) {
        const slidesCount = $(`.slide-item[data-tab-id="${activeTabId}"]`).length;
        if (slidesCount === 0) return;
        
        // Wrap around bounds
        if (index >= slidesCount) index = 0;
        if (index < 0) index = slidesCount - 1;
        
        activeSlideIndexes[activeTabId] = index;
        
        // Update slide texts
        $(`.slide-item[data-tab-id="${activeTabId}"]`).removeClass('active').hide();
        $(`#slide-item-${activeTabId}-${index}`).addClass('active').fadeIn(400);
        
        // Update slide images
        $(`.slide-img[data-tab-id]`).removeClass('active');
        $(`#slide-img-${activeTabId}-${index}`).addClass('active');
        
        // Update dots
        $('.slider-pagination .dot').removeClass('active');
        $(`.slider-pagination .dot[data-index="${index}"]`).addClass('active');
      }

      // Tab click logic
      $('.tab-btn').on('click', function() {
        const tabId = $(this).data('tab-id');
        if (tabId === activeTabId) return;
        
        // Switch tab class
        $('.tab-btn').removeClass('active');
        $(this).addClass('active');
        
        activeTabId = tabId;
        
        // Hide all slides first
        $('.slide-item').removeClass('active').hide();
        $('.slide-img').removeClass('active');
        
        // Show active slide for new tab
        const currentIndex = activeSlideIndexes[activeTabId];
        showSlide(currentIndex);
        renderPagination();
      });

      // Pagination dot click logic
      $(document).on('click', '.slider-pagination .dot', function() {
        const index = $(this).data('index');
        showSlide(index);
      });

      // Prev/Next Arrows click logic
      $('.nav-prev').on('click', function() {
        const currentIndex = activeSlideIndexes[activeTabId];
        showSlide(currentIndex - 1);
      });
      $('.nav-next').on('click', function() {
        const currentIndex = activeSlideIndexes[activeTabId];
        showSlide(currentIndex + 1);
      });

      // Initial layout setup for desktop
      renderPagination();
      
      // ------------------------------------------
      // MOBILE INTERACTIVITY (ACCORDION & BACKGROUND SLIDERS)
      // ------------------------------------------
      
      // Function to refresh the active accordion item's background image
      function updateAccordionBackground($accItem) {
        const $activeMobileSlide = $accItem.find('.mobile-slide-item.active');
        const bgImg = $activeMobileSlide.data('image');
        $accItem.find('.acc-content').css('background-image', `url(${bgImg})`);
      }
      
      // Initialize backgrounds for all expanded accordions
      $('.acc-item').each(function() {
        if ($(this).hasClass('active')) {
          updateAccordionBackground($(this));
        }
      });

      // Accordion header toggle click
      $('.acc-header').on('click', function() {
        const $currentItem = $(this).closest('.acc-item');
        
        if ($currentItem.hasClass('active')) {
          // Collapse it
          $currentItem.removeClass('active');
          $currentItem.find('.acc-content').slideUp(300);
          $(this).find('.toggle-icon').attr('src', 'images/plus-01.svg');
        } else {
          // Collapse other active panels
          $('.acc-item.active').each(function() {
            $(this).removeClass('active');
            $(this).find('.acc-content').slideUp(300);
            $(this).find('.toggle-icon').attr('src', 'images/plus-01.svg');
          });
          
          // Expand current
          $currentItem.addClass('active');
          $currentItem.find('.acc-content').slideDown(300, function() {
            updateAccordionBackground($currentItem);
          });
          $(this).find('.toggle-icon').attr('src', 'images/minus-01.svg');
        }
      });

      // Mobile slide pagination dots click
      $('.mobile-slider-pagination').on('click', '.dot', function(e) {
        e.stopPropagation(); // Prevent accordion header toggle
        
        const $dot = $(this);
        const index = $dot.data('slide-index');
        const $accItem = $dot.closest('.acc-item');
        
        // Update dots active state
        $dot.siblings().removeClass('active');
        $dot.addClass('active');
        
        // Switch active mobile slide item
        const $slides = $accItem.find('.mobile-slide-item');
        $slides.removeClass('active').addClass('d-none');
        
        const $targetSlide = $slides.eq(index);
        $targetSlide.removeClass('d-none').addClass('active');
        
        // Update background image for mobile accordion content
        updateAccordionBackground($accItem);
      });
      
    });
  </script>
</body>
</html>
