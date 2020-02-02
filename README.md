# Content Backup job for Kirby Janitor (WIP)

## Installation

### Step 1: Install Kirby Janitor plugin

https://github.com/bnomei/kirby3-janitor

### Step 2: Add this to site/config.php

```php
'bnomei.janitor.jobs.extends' => [
  'medienbaecker.content-backup.jobs'
],
```

### Step 3: Add a backup field

```yml
backup:
  type: janitor
  label: Download backup
  progress: Creating backup...
  job: backup
```