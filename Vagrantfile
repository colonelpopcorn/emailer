Vagrant.configure("2") do |config|

  config.vm.box = "ubuntu/xenial64"

  config.vm.network "forwarded_port", guest: 80, host: 8080

  config.vm.provider "virtualbox" do |vb|
    vb.memory = "1024"
  end

  config.vm.provision "ansible_local" do |ansible|
    ansible.install = true
    ansible.verbose = true
    ansible.become = true
    ansible.galaxy_role_file = "scripts/requirements.yml"
    ansible.playbook = "scripts/main.yml"
  end
end
