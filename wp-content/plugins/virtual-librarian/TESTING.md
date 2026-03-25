# Testing Checklist for Virtual Librarian Plugin

## 1. Chatbot Functionality
- [ ] Widget appears in the bottom right corner (or as configured).
- [ ] AI responds to general queries.
- [ ] Commands like `/help`, `/emoji`, `/stat` work as expected.
- [ ] Image generation (`/aimg`) produces a visual response.
- [ ] Chat history persists across page reloads.

## 2. Voice Assistant
- [ ] Microphone button appears on mobile devices.
- [ ] Assistant listens and recognizes Russian speech.
- [ ] Assistant speaks responses back.
- [ ] Voice commands (e.g., "Открой новости") perform correct actions.

## 3. Knowledge Base
- [ ] Cron job `virtual_librarian_daily_cron` is registered.
- [ ] Manual sync (`sync_knowledge_base`) extracts data correctly from the target site.

## 4. Admin Settings
- [ ] Settings page is accessible under Settings -> Virtual Librarian.
- [ ] All settings save correctly.
- [ ] Migration from theme mods works on activation.

## 5. Portability
- [ ] Plugin works correctly when switching themes.
- [ ] No PHP errors or warnings in debug log.
