workflow "Checkout " {
  on = "push"
  resolves = ["docker://docker/compose"]
}

action "docker://docker/compose" {
  uses = "docker://docker/compose"
  runs = "docker-compose"
  args = "up - d"
}
