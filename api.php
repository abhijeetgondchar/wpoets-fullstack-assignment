<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/db.php';

// Safe fallback data matching the style guide and mockups
$fallbackData = [
    'tabs' => [
        [
            'id' => 1,
            'title' => 'Learning',
            'icon' => 'images/DL-learning.svg',
            'sort_order' => 1
        ],
        [
            'id' => 2,
            'title' => 'Technology',
            'icon' => 'images/DL-technology.svg',
            'sort_order' => 2
        ],
        [
            'id' => 3,
            'title' => 'Communication',
            'icon' => 'images/DL-communication.svg',
            'sort_order' => 3
        ]
    ],
    'slides' => [
        [
            'id' => 1,
            'tab_id' => 1,
            'badge' => 'DIGITAL LEARNING INFRASTRUCTURE',
            'title' => 'Usability enhancement and Training for Transaction Portal for Customers',
            'button_text' => 'Learn More',
            'button_link' => '#',
            'image' => 'images/DL-Learning-1.jpg',
            'sort_order' => 1
        ],
        [
            'id' => 2,
            'tab_id' => 1,
            'badge' => 'E-LEARNING METHODOLOGIES',
            'title' => 'Interactive training simulations to align distributed departments',
            'button_text' => 'Learn More',
            'button_link' => '#',
            'image' => 'images/DL-Learning-1.jpg',
            'sort_order' => 2
        ],
        [
            'id' => 3,
            'tab_id' => 2,
            'badge' => 'ENTERPRISE TECHNOLOGY PACKAGES',
            'title' => 'Cloud infrastructure scaling and workflow digitization for legacy systems',
            'button_text' => 'Learn More',
            'button_link' => '#',
            'image' => 'images/DL-Technology.jpg',
            'sort_order' => 1
        ],
        [
            'id' => 4,
            'tab_id' => 3,
            'badge' => 'STRATEGIC COMMUNICATION',
            'title' => 'Brand positioning, workshops, and internal communication strategies',
            'button_text' => 'Learn More',
            'button_link' => '#',
            'image' => 'images/DL-Communication.jpg',
            'sort_order' => 1
        ]
    ]
];

// Helper to get input parameters (handling both JSON body and standard form post)
function getRequestData() {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    if (is_array($data)) {
        return array_merge($_REQUEST, $data);
    }
    return $_REQUEST;
}

$request = getRequestData();
$action = isset($request['action']) ? $request['action'] : '';

// Handle OPTIONS requests (for CORS preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    switch ($action) {
        case 'get_data':
            try {
                $db = getDbConnection();
                // Fetch Tabs
                $stmt = $db->query("SELECT * FROM tabs ORDER BY sort_order ASC, id ASC");
                $tabs = $stmt->fetchAll();
                
                // Fetch Slides
                $stmt = $db->query("SELECT * FROM slides ORDER BY sort_order ASC, id ASC");
                $slides = $stmt->fetchAll();
                
                echo json_encode([
                    'status' => 'success',
                    'source' => 'database',
                    'tabs' => $tabs,
                    'slides' => $slides
                ]);
            } catch (Exception $e) {
                // Return fallback data on DB failure
                echo json_encode([
                    'status' => 'success',
                    'source' => 'fallback',
                    'message' => 'Database connection failed. Serving fallback mock data. Error: ' . $e->getMessage(),
                    'tabs' => $fallbackData['tabs'],
                    'slides' => $fallbackData['slides']
                ]);
            }
            break;

        case 'list_images':
            $dir = __DIR__ . '/images';
            $images = [];
            if (is_dir($dir)) {
                $files = scandir($dir);
                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..' && (strpos($file, '.jpg') !== false || strpos($file, '.jpeg') !== false || strpos($file, '.png') !== false || strpos($file, '.svg') !== false)) {
                        $images[] = 'images/' . $file;
                    }
                }
            }
            echo json_encode([
                'status' => 'success',
                'images' => $images
            ]);
            break;

        case 'create_tab':
            $db = getDbConnection();
            $title = isset($request['title']) ? trim($request['title']) : '';
            $icon = isset($request['icon']) ? trim($request['icon']) : '';
            $sort_order = isset($request['sort_order']) ? intval($request['sort_order']) : 0;
            
            if (empty($title) || empty($icon)) {
                throw new Exception("Title and icon are required.");
            }
            
            $stmt = $db->prepare("INSERT INTO tabs (title, icon, sort_order) VALUES (?, ?, ?)");
            $stmt->execute([$title, $icon, $sort_order]);
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Tab created successfully',
                'id' => $db->lastInsertId()
            ]);
            break;

        case 'update_tab':
            $db = getDbConnection();
            $id = isset($request['id']) ? intval($request['id']) : 0;
            $title = isset($request['title']) ? trim($request['title']) : '';
            $icon = isset($request['icon']) ? trim($request['icon']) : '';
            $sort_order = isset($request['sort_order']) ? intval($request['sort_order']) : 0;
            
            if ($id <= 0 || empty($title) || empty($icon)) {
                throw new Exception("ID, title, and icon are required.");
            }
            
            $stmt = $db->prepare("UPDATE tabs SET title = ?, icon = ?, sort_order = ? WHERE id = ?");
            $stmt->execute([$title, $icon, $sort_order, $id]);
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Tab updated successfully'
            ]);
            break;

        case 'delete_tab':
            $db = getDbConnection();
            $id = isset($request['id']) ? intval($request['id']) : 0;
            
            if ($id <= 0) {
                throw new Exception("ID is required.");
            }
            
            $stmt = $db->prepare("DELETE FROM tabs WHERE id = ?");
            $stmt->execute([$id]);
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Tab deleted successfully'
            ]);
            break;

        case 'create_slide':
            $db = getDbConnection();
            $tab_id = isset($request['tab_id']) ? intval($request['tab_id']) : 0;
            $badge = isset($request['badge']) ? trim($request['badge']) : '';
            $title = isset($request['title']) ? trim($request['title']) : '';
            $button_text = isset($request['button_text']) ? trim($request['button_text']) : 'Learn More';
            $button_link = isset($request['button_link']) ? trim($request['button_link']) : '#';
            $image = isset($request['image']) ? trim($request['image']) : '';
            $sort_order = isset($request['sort_order']) ? intval($request['sort_order']) : 0;
            
            if ($tab_id <= 0 || empty($badge) || empty($title) || empty($image)) {
                throw new Exception("Tab ID, badge, title, and image are required.");
            }
            
            $stmt = $db->prepare("INSERT INTO slides (tab_id, badge, title, button_text, button_link, image, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$tab_id, $badge, $title, $button_text, $button_link, $image, $sort_order]);
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Slide created successfully',
                'id' => $db->lastInsertId()
            ]);
            break;

        case 'update_slide':
            $db = getDbConnection();
            $id = isset($request['id']) ? intval($request['id']) : 0;
            $tab_id = isset($request['tab_id']) ? intval($request['tab_id']) : 0;
            $badge = isset($request['badge']) ? trim($request['badge']) : '';
            $title = isset($request['title']) ? trim($request['title']) : '';
            $button_text = isset($request['button_text']) ? trim($request['button_text']) : 'Learn More';
            $button_link = isset($request['button_link']) ? trim($request['button_link']) : '#';
            $image = isset($request['image']) ? trim($request['image']) : '';
            $sort_order = isset($request['sort_order']) ? intval($request['sort_order']) : 0;
            
            if ($id <= 0 || $tab_id <= 0 || empty($badge) || empty($title) || empty($image)) {
                throw new Exception("All fields are required for update.");
            }
            
            $stmt = $db->prepare("UPDATE slides SET tab_id = ?, badge = ?, title = ?, button_text = ?, button_link = ?, image = ?, sort_order = ? WHERE id = ?");
            $stmt->execute([$tab_id, $badge, $title, $button_text, $button_link, $image, $sort_order, $id]);
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Slide updated successfully'
            ]);
            break;

        case 'delete_slide':
            $db = getDbConnection();
            $id = isset($request['id']) ? intval($request['id']) : 0;
            
            if ($id <= 0) {
                throw new Exception("ID is required.");
            }
            
            $stmt = $db->prepare("DELETE FROM slides WHERE id = ?");
            $stmt->execute([$id]);
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Slide deleted successfully'
            ]);
            break;

        default:
            throw new Exception("Invalid action: '$action'.");
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
