# City Library Theme 2.0 📚✨

A modern, accessible, and responsive WordPress theme designed specifically for public libraries. This version (v2.0) focuses on a unified "White Mode" design, enhanced accessibility, and improved user experience for events and services.

## 🌟 Key Features

### 1. Unified "White Mode" Design
*   **Strict AAA Compliance:** All dark mode features and conflicting styles have been removed to enforce a clean, high-contrast white design system (`bg-white`, `text-slate-900`).
*   **Standardized Cards:** News, Events, and Promo blocks now use a consistent card style with rounded corners (`rounded-[2rem]`) and soft shadows.
*   **Responsive Typography:** Font sizes are optimized for all screens, ensuring readability on mobile (`375px`) up to large desktops (`1440px+`).

### 2. Enhanced "Afisha" (Events) Section
*   **Interactive Slider:** Features a restored Swiper.js slider for browsing upcoming events.
*   **Quick View Modal:** Users can click any event poster to open a full-screen, adaptive modal with detailed information and a link to the full record.
*   **Adaptive Layout:** The section title and description are now centered and fully responsive.

### 3. Accessibility Tools (a11y)
*   **Settings Toggle:** A dedicated "Eye" icon in the header opens a menu to toggle:
    *   **Large Text:** Increases font size for better readability.
    *   **High Contrast:** Switches to a high-contrast black-and-white mode.
*   **Screen Reader Support:**
    *   Sidebar toggle now correctly reports `aria-expanded` state.
    *   Icon-only buttons include descriptive `aria-label` attributes.
    *   A "Skip to content" link is included for keyboard navigation.

### 4. Service Integrations
*   **Book Renewal Online:** A floating action button (bottom-left) opens a modal form for users to renew books without logging in.
*   **Cookie Consent:** A GDPR-compliant banner with a clean design.
*   **Mobile-First Navigation:** A dedicated slide-out mobile menu and a fixed bottom navigation bar for easy access on small screens.

---

## 🛠 Installation

1.  Upload the `city-library` folder to your `/wp-content/themes/` directory.
2.  Activate the theme via the **Appearance > Themes** menu in WordPress.
3.  Install required plugins (if any are prompted, though the theme is standalone).

---

## ⚙️ Configuration (Customizer)

All theme settings are managed via the native WordPress Customizer (**Appearance > Customize**).

### **Header & Hero**
*   **Header Settings:** Change the library name, subtitle, and font family (Inter, Montserrat, Playfair Display).
*   **Hero Section:** Enable/disable the large hero banner, change background image, title, and call-to-action buttons.

### **Events (Afisha)**
*   **Afisha Section:** Upload event posters, set titles, links, and add "New/Featured" badges.
*   **Background Style:** Choose between a default pattern or a modern gradient.

### **Important Info & Promo**
*   **Important Information:** Set alert messages (e.g., "Sanitary Day") and configure the 8 quick-access link icons.
*   **Promo Block:** Configure the special offer block (Image, Title, Text, Button).

### **Footer & Contacts**
*   **Footer Settings:** Update address, phone, email, and description text.
*   **Branch Emails:** Configure recipient emails for the "Book Renewal" form for each library branch.

---

## 📝 Changelog (v2.0)

*   **Removed:** "Lumos" (Magic Mode) feature and all associated assets (`magic-mode.js`, `dark-mode.js`).
*   **Fixed:** Sidebar toggle accessibility (`aria-expanded`).
*   **Fixed:** Responsive grid layout on large screens (prevented card squashing).
*   **Updated:** Standardized all UI components to use the new white design system.
*   **Added:** Functional Accessibility settings (Text Size / Contrast).
*   **Added:** Full-screen modal interaction for Event posters.

---

*Theme developed by Palette Agent.* 🎨
