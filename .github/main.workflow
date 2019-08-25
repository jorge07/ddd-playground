workflow "Checkout " {
  on = "push"
  resolves = ["docker://docker/compose"]
}

action "docker://docker/compose" {
  uses = "docker://docker/compose:1.25.0-rc2" 
  runs = "docker-compose"
  args = "up - d"
}
