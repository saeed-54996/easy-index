<?php
// Define the base directory (change to your root directory)
$baseDirectory = realpath('/home/user/htdocs/site.com/folder-to-index');
$baseUrl = '/folder-to-index'; // The base URL relative to the site's root

// Get the directory to list from the query parameter or default to the base directory
$directory = isset($_GET['dir']) ? realpath($_GET['dir']) : $baseDirectory;

// Security check: Ensure the requested directory is within the base directory
if (strpos($directory, $baseDirectory) !== 0 || !is_dir($directory)) {
    $directory = $baseDirectory;
}

// Get all files and directories within the current directory
$files = array_diff(scandir($directory), ['.', '..']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Explorer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center">
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">
            Files in <?php echo htmlspecialchars(str_replace($baseDirectory, '', $directory) ?: '/'); ?>
        </h1>
        
        <!-- Back button -->
        <?php if ($directory !== $baseDirectory): ?>
            <div class="mb-4">
                <a href="?dir=<?php echo urlencode(dirname($directory)); ?>"
                   class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">
                    🔙 Back
                </a>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php if (empty($files)): ?>
                <div class="col-span-full text-center text-gray-600">
                    <p>No files or folders found in the directory.</p>
                </div>
            <?php else: ?>
                <?php foreach ($files as $file): ?>
                    <?php
                    $filePath = $directory . '/' . $file;
                    $isDir = is_dir($filePath);
                    $relativePath = str_replace($baseDirectory, '', $filePath);
                    $fileUrl = $baseUrl . $relativePath;
                    $isVideo = preg_match('/\.(mp4|mov|avi|mkv)$/i', $file);
                    ?>
                    <div class="bg-white shadow-md rounded-lg p-4 flex flex-col items-center">
                        <div class="text-gray-600 text-sm mb-2">
                            <?php echo $isDir ? '📁 Directory' : '📄 File'; ?>
                        </div>
                        <?php if ($isDir): ?>
                            <!-- Link to navigate into the folder -->
                            <a href="?dir=<?php echo urlencode($filePath); ?>" 
                               class="text-blue-500 hover:underline truncate">
                                <?php echo htmlspecialchars($file); ?>
                            </a>
                        <?php else: ?>
                            <!-- Link to open the file -->
                            <a href="<?php echo htmlspecialchars($fileUrl); ?>" 
                               target="_blank" class="text-blue-500 hover:underline truncate">
                                <?php echo htmlspecialchars($file); ?>
                            </a>
                            <!-- Play button for video files -->
                            <?php if ($isVideo): ?>
                                <button 
                                    onclick="playVideo('<?php echo htmlspecialchars($fileUrl); ?>')"
                                    class="bg-green-500 text-white px-4 py-2 mt-2 rounded shadow hover:bg-green-600">
                                    ▶ Play Video
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                        <span class="text-gray-500 text-xs mt-2">
                            <?php
                            if ($isDir) {
                                echo '-';
                            } else {
                                // Display size in MB with 2 decimal places
                                echo number_format(filesize($filePath) / (1024 * 1024), 2) . ' MB';
                            }
                            ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Video Player Modal -->
    <div id="videoModal" class="fixed inset-0 bg-black bg-opacity-75 flex justify-center items-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-4 relative w-11/12 sm:w-3/4 lg:w-1/2 max-h-screen overflow-auto">
        <button 
            onclick="closeModal()" 
            class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-600 z-[999]">
            ✖ Close
        </button>
        <video id="videoPlayer" class="w-full max-h-[75vh] object-contain" controls></video>
    </div>
</div>


    <script>
        function playVideo(url) {
            const modal = document.getElementById('videoModal');
            const videoPlayer = document.getElementById('videoPlayer');
            videoPlayer.src = url;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            const modal = document.getElementById('videoModal');
            const videoPlayer = document.getElementById('videoPlayer');
            videoPlayer.pause();
            videoPlayer.src = '';
            modal.classList.add('hidden');
        }
    </script>
</body>
</html>
