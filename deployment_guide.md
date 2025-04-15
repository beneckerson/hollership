# GitHub Pages Deployment Instructions

## Setting Up GitHub Pages with Your Custom Domain

Follow these steps to deploy your website to GitHub Pages and configure it with your custom domain:

### Step 1: Create a GitHub Repository

1. Sign in to your GitHub account (or create one at [github.com](https://github.com))
2. Click the "+" icon in the top right corner and select "New repository"
3. Name your repository (e.g., "scholarship-website" or use your domain name)
4. Make sure the repository is set to "Public"
5. Click "Create repository"

### Step 2: Upload Your Website Files

1. Extract the provided ZIP file to your local computer
2. In your new GitHub repository, click "uploading an existing file"
3. Drag and drop all the extracted files and folders, or use the file selector
4. Add a commit message (e.g., "Initial website upload")
5. Click "Commit changes"

### Step 3: Configure GitHub Pages

1. In your repository, go to "Settings"
2. Scroll down to the "GitHub Pages" section
3. Under "Source", select "main" branch
4. Click "Save"
5. Wait a few minutes for GitHub to build your site

### Step 4: Configure Your Custom Domain

1. In the GitHub Pages section of your repository settings, enter your custom domain (e.g., theworldsgreatestscholarshipintheuniversescholarship.com) in the "Custom domain" field
2. Click "Save"
3. Check the "Enforce HTTPS" option (recommended for security)

### Step 5: Update DNS Settings with Your Domain Provider

1. Log in to your domain registrar (where you purchased your domain)
2. Go to the DNS settings for your domain
3. Add the following records:

   **Option A: Apex Domain (example.com)**
   Add these A records pointing to GitHub's servers:
   ```
   A    @    185.199.108.153
   A    @    185.199.109.153
   A    @    185.199.110.153
   A    @    185.199.111.153
   ```

   **Option B: www Subdomain (www.example.com)**
   Add a CNAME record:
   ```
   CNAME    www    yourusername.github.io
   ```
   (Replace "yourusername" with your actual GitHub username)

4. Wait for DNS changes to propagate (can take up to 48 hours)

### Step 6: Verify Your Setup

1. Visit your custom domain in a web browser
2. Ensure all pages, images, and functionality work correctly
3. Test on different devices to verify responsive design

## Updating Your Website in the Future

To make changes to your website:

1. Clone the repository to your local machine
2. Make your changes to the files
3. Commit and push the changes back to GitHub
4. GitHub Pages will automatically update your site

## Need Help?

If you encounter any issues with the deployment process, refer to the [GitHub Pages documentation](https://docs.github.com/en/pages) or contact GitHub support.
