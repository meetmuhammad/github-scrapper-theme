# WordPress Template with Scraped Data Display

## Project Overview

This WordPress template, named "scraped-data-template.php," allows you to create visually appealing layouts to display data scraped from the GitHub API. It's designed to be responsive and user-friendly, showcasing information about creators in a creative and engaging manner.

## Project Structure

The project consists of several key components:

- **Main Template File**: `scraped-data-template.php` serves as the primary template for displaying the scraped data. It uses HTML, CSS, and JavaScript to create a visually appealing layout.

- **User Card Template**: `github-user-card.php` is a separate file containing HTML code for a single user card. This template will be used in a `foreach` loop to render all scraped users.

- **Functions**: PHP functions are defined in `functions.php`, including AJAX code on the server side. Additionally, a variable for the bearer token is declared here.

- **Client-Side JavaScript**: The client-side AJAX logic is encapsulated in `scrapper.js`, responsible for sending requests and handling responses.

- **Styles**: Tailwind is used to style the template. Style for loader icon is added in the style.css file.

## How to Use the Project

1. **Download WordPress Theme**:
   - Download WordPress theme "Github Scraper Theme"
   - Install and activate the theme

2. **Scraping Data**:
   - Specify the number of GitHub users they want to scrape and click on Scrape button.

## **Functionality Explained**

1. **AJAX Request**:
   - When a user clicks the "Scrap" button, an AJAX request is sent to the server (PHP).
   - The request should include the `user_qty` field, specifying the number of users to scrape.

2. **Server-Side Processing**:
   - On the server side, the `github_scraper` function is triggered in `functions.php`.
   - This function sends GET requests to the GitHub API v3 to retrieve data about creators.

3. **Data Rendering**:
   - For each user object received, the function iterates through them and sends a request to the user's GitHub API URL to obtain additional data.

4. **HTML Generation**:
   - The retrieved data is sent to the `github-user-card.php` template, where the HTML for each user card is generated.

5. **Frontend Rendering**:
   - Once all HTML is generated, the response is sent to the frontend, where the user cards are rendered on the page.

## Testing

It's essential to thoroughly test the template to ensure that it functions correctly and accurately displays the scraped data on different devices. Verify that the layout remains responsive and visually appealing across various screen sizes.


Happy scraping and displaying your GitHub creator data using this WordPress template!
