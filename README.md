
# Responsive File Explorer in PHP  

A responsive file explorer built with PHP and styled using Tailwind CSS. This tool allows you to navigate directories, view files, and play video files directly in an inline modal player.  

## Features  
- **Responsive Design**: Fully responsive using Tailwind CSS.  
- **Directory Navigation**: Navigate through directories while maintaining a secure root path.  
- **File Listing**: Displays files with sizes and types.  
- **Inline Video Player**: Play video files in a modal without downloading.  
- **Security**: Ensures navigation is restricted to a specific base directory.  

## Installation  

1. Clone the repository:  
   ```bash  
   git clone https://github.com/saeed-54996/easy-index.git  
   cd easy-index  
   ```  

2. Configure the base directory:  
   In the PHP script, update the `$baseDirectory` and `$baseUrl` variables to point to your target directory:  
   ```php  
   $baseDirectory = realpath('/path/to/your/base/directory');  
   $baseUrl = '/relative/path/to/base/directory';  
   ```  

3. Deploy the files to your web server (e.g., Nginx or Apache).  

4. Access the explorer in your browser by navigating to the hosted URL.  

## Usage  

- Click on folders to navigate into them.  
- Click on video files to open and play them in the modal.  
- Use the "Back" button to navigate up the directory structure (limited to the root directory).  

## Dependencies  

- PHP 7.4 or higher.  
- Tailwind CSS (included in the project).  

## License  

This project is licensed under the MIT License. Feel free to use and modify it as needed.  
