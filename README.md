# Image Upload App

This is a simple web application built with Laravel for uploading images. Users can upload multiple images at once, view the uploaded images, and download selected images as a zip file.

## Features

- **Image Upload**: Users can upload multiple images at once.
- **Image Viewing**: View all uploaded images with their details such as name and upload date.
- **Image Download**: Download selected images as a zip file.
- **API Endpoint**: Retrieve image details in JSON format via API.

## Installation

1. Clone this repository to your local machine:

    ```
    git clone <repository-url>
    ```

2. Navigate to the project directory:

    ```
    cd image-upload-app
    ```

3. Install dependencies using Composer:

    ```
    composer install
    ```

4. Copy the `.env.example` file to `.env` and configure your environment variables such as database connection:

    ```
    cp .env.example .env
    ```

5. Generate an application key:

    ```
    php artisan key:generate
    ```

6. Run database migrations to create the necessary tables:

    ```
    php artisan migrate
    ```

7. Start the development server:

    ```
    php artisan serve
    ```

8. Access the application in your web browser at `http://localhost:8000`.

## Usage

- Upload Images: Visit the home page and use the provided form to upload images.
- View Uploaded Images: Click on the "View All Uploaded Files" button to see a list of uploaded images.
- View Image on full size by clicking on the picture.
- Download Images: Select the images you want to download and click the "Download Selected Images" button.
- API Endpoint: Access image list in JSON format by making a GET request to `/api/images` and image details by making a GET request to `/api/images/{id}`.

## Credits

This project was created by Rose Idealy.

## License

This project is open-source and available under the [MIT License](LICENSE).

## Additional Documentation

- [README in Russian (README_ru.md)](README_ru.md)

 
