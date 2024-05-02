<?php

// Get the URL parameter from the request
$websiteUrl = $_GET['url'] ?? '';

// Validate the URL
if (!filter_var($websiteUrl, FILTER_VALIDATE_URL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid URL. Please enter a valid URL starting with http:// or https://']);
    exit;
}

// Generate a unique filename for the screenshot
$screenshotFilename = 'screenshot_' . uniqid() . '.png';

// Command to capture the screenshot using Puppeteer (assuming Puppeteer is installed)
$command = "node capture_screenshot.js \"$websiteUrl\" \"$screenshotFilename\"";

// Execute the command
exec($command, $output, $exitCode);

// Check if the command executed successfully
if ($exitCode !== 0) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to generate screenshot']);
    exit;
}

// Return the URL of the generated screenshot
$screenshotUrl = $screenshotFilename;
echo json_encode(['screenshotUrl' => $screenshotUrl]);

?>
